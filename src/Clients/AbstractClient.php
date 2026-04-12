<?php

declare(strict_types=1);

namespace Montonio\Clients;

use CurlHandle;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use JsonException;
use Montonio\Exception\CurlErrorException;
use Montonio\Exception\RequestException;
use stdClass;

abstract class AbstractClient
{
    protected const ENCODING_ALGORITHM = 'HS256';

    public function __construct(
        private string $accessKey,
        private string $secretKey,
        private string $environment,
    ) {}

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

    /**
     * @throws Exception
     */
    protected function call(string $method, string $url, ?string $payload = null, array $headers = []): array
    {
        $ch = $this->prepareCurl($url);

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        if ($payload && $method !== 'GET') {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        }

        return $this->execute($ch);
    }

    /**
     * @throws Exception
     */
    private function execute(CurlHandle $ch): array
    {
        $response = curl_exec($ch);

        // @codeCoverageIgnoreStart
        if ($response === false) {
            throw new CurlErrorException(curl_error($ch), curl_errno($ch), $ch);
            // @codeCoverageIgnoreEnd
        }

        $httpStatus = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if (200 <= $httpStatus && $httpStatus <= 299) {
            curl_close($ch);
            return json_decode($response, true) ?? [];
        }

        $message = '';

        if (400 <= $httpStatus && $httpStatus <= 499) {
            try {
                $body = json_decode($response, true, 512, JSON_THROW_ON_ERROR);
                $message = $body['error'] ?? '';
                // @codeCoverageIgnoreStart
            } catch (JsonException $e) {
                // @codeCoverageIgnoreEnd
            }
        }

        throw new RequestException($message, $httpStatus, $response, $ch);
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
}
