<?php

declare(strict_types=1);

namespace Montonio\Clients;

use CurlHandle;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use JsonException;
use Montonio\Enums\Environment;
use Montonio\Exception\ApiException;
use Montonio\Exception\AuthenticationException;
use Montonio\Exception\CurlErrorException;
use Montonio\Exception\NotFoundException;
use Montonio\Exception\RateLimitException;
use Montonio\Exception\ServerException;
use Montonio\Exception\TransportException;
use Montonio\Exception\ValidationException;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use stdClass;

abstract class AbstractClient
{
    protected const ENCODING_ALGORITHM = 'HS256';

    private readonly string $environment;

    public function __construct(
        private readonly string $accessKey,
        private readonly string $secretKey,
        Environment|string $environment,
        private readonly ?ClientInterface $httpClient = null,
        private readonly ?RequestFactoryInterface $requestFactory = null,
        private readonly ?StreamFactoryInterface $streamFactory = null,
    ) {
        $this->environment = $environment instanceof Environment ? $environment->value : $environment;

        if ($this->httpClient !== null && ($this->requestFactory === null || $this->streamFactory === null)) {
            throw new \InvalidArgumentException(
                'When providing a PSR-18 ClientInterface, you must also provide RequestFactoryInterface and StreamFactoryInterface.'
            );
        }
    }

    public function generateToken(array $payload = []): string
    {
        $payload['accessKey'] = $this->getAccessKey();
        $payload['exp'] ??= time() + 600;
        $payload['iat'] = time();

        return JWT::encode($payload, $this->getSecretKey(), static::ENCODING_ALGORITHM);
    }

    /**
     * Decode and verify a JWT token signed with your secret key.
     *
     * Use this to verify webhook tokens from Montonio:
     * - Order webhooks send {"orderToken": "<jwt>"} with fields: uuid, merchantReference, paymentStatus, etc.
     * - Refund webhooks send {"refundToken": "<jwt>"} with fields: refundUuid, refundStatus, refundAmount, etc.
     *
     * @throws \Firebase\JWT\SignatureInvalidException if the token signature is invalid
     * @throws \Firebase\JWT\ExpiredException if the token has expired
     */
    public function decodeToken(string $token): stdClass
    {
        return JWT::decode($token, new Key($this->getSecretKey(), static::ENCODING_ALGORITHM));
    }

    protected function call(string $method, string $url, ?string $payload = null, array $headers = []): array
    {
        if ($this->httpClient !== null) {
            return $this->callPsr18($method, $url, $payload, $headers);
        }

        return $this->callCurl($method, $url, $payload, $headers);
    }

    private function callPsr18(string $method, string $url, ?string $payload, array $headers): array
    {
        $request = $this->requestFactory->createRequest($method, $url);

        foreach ($headers as $header) {
            [$name, $value] = explode(':', $header, 2);
            $request = $request->withHeader(trim($name), trim($value));
        }

        if ($payload !== null && $method !== 'GET') {
            $request = $request->withBody($this->streamFactory->createStream($payload));
        }

        try {
            $response = $this->httpClient->sendRequest($request);
        } catch (ClientExceptionInterface $e) {
            throw new TransportException($e->getMessage(), (int) $e->getCode(), null, $e);
        }

        return $this->handleResponse(
            $response->getStatusCode(),
            (string) $response->getBody(),
        );
    }

    private function callCurl(string $method, string $url, ?string $payload, array $headers): array
    {
        $ch = $this->prepareCurl($url);

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        if ($payload !== null && $method !== 'GET') {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        }

        $response = curl_exec($ch);

        // @codeCoverageIgnoreStart
        if ($response === false) {
            throw new TransportException(curl_error($ch), curl_errno($ch), $ch);
            // @codeCoverageIgnoreEnd
        }

        return $this->handleResponse(
            (int) curl_getinfo($ch, CURLINFO_HTTP_CODE),
            $response,
            $ch,
        );
    }

    private function handleResponse(int $httpStatus, string $response, ?CurlHandle $ch = null): array
    {
        if ($httpStatus >= 200 && $httpStatus <= 299) {
            if ($ch !== null) {
                curl_close($ch);
            }
            return json_decode($response, true) ?? [];
        }

        $message = '';
        if ($httpStatus >= 400) {
            try {
                $body = json_decode($response, true, 512, JSON_THROW_ON_ERROR);
                $message = $body['error'] ?? '';
                // @codeCoverageIgnoreStart
            } catch (JsonException) {
                // @codeCoverageIgnoreEnd
            }
        }

        match (true) {
            $httpStatus === 401, $httpStatus === 403 => throw new AuthenticationException($message, $httpStatus, $response, $ch),
            $httpStatus === 404 => throw new NotFoundException($message, $httpStatus, $response, $ch),
            $httpStatus === 429 => throw new RateLimitException($message, $httpStatus, $response, $ch),
            $httpStatus === 400, $httpStatus === 422 => throw new ValidationException($message, $httpStatus, $response, $ch),
            $httpStatus >= 500 => throw new ServerException($message, $httpStatus, $response, $ch),
            default => throw new ApiException($message, $httpStatus, $response, $ch),
        };
    }

    private function prepareCurl(string $url): CurlHandle
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_PORT, 443);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);

        return $ch;
    }

    protected function getAccessKey(): string
    {
        return $this->accessKey;
    }

    protected function getSecretKey(): string
    {
        return $this->secretKey;
    }

    protected function getEnvironment(): string
    {
        return $this->environment;
    }

    protected function getHttpClient(): ?ClientInterface
    {
        return $this->httpClient;
    }

    protected function getRequestFactory(): ?RequestFactoryInterface
    {
        return $this->requestFactory;
    }

    protected function getStreamFactory(): ?StreamFactoryInterface
    {
        return $this->streamFactory;
    }
}
