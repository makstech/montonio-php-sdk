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
use Montonio\MontonioClient;
use stdClass;

abstract class AbstractClient
{
    protected const SANDBOX_URL = 'https://sandbox-stargate.montonio.com/api';
    protected const LIVE_URL = 'https://stargate.montonio.com/api';

    protected const ENCODING_ALGORITHM = 'HS256';

    public function __construct(
        private string $accessKey,
        private string $secretKey,
        private string $environment,
    ) {}

    protected function get(string $url, array $params = []): array
    {
        return $this->call(
            'GET',
            $this->getUrl($url),
            null,
            [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $this->generateToken(),
            ],
        );
    }

    protected function post(string $url, array $payload = []): array
    {
        return $this->call(
            'POST',
            $this->getUrl($url),
            json_encode(['data' => $this->generateToken($payload)]),
            ['Content-Type: application/json'],
        );
    }

    public function generateToken(array $payload = []): string
    {
        $payload['accessKey'] = $this->getAccessKey();
        $payload['exp'] ??= time() + 600;
        $payload['iat'] = time();

        return JWT::encode($payload, $this->getSecretKey(), static::ENCODING_ALGORITHM);
    }

    public function decodeToken(string $token): stdClass
    {
        return JWT::decode($token, new Key($this->getSecretKey(), static::ENCODING_ALGORITHM));
    }

    protected function getUrl(string $path): string
    {
        return ($this->isSandbox() ? self::SANDBOX_URL : self::LIVE_URL)
            . (str_starts_with($path, '/') ? '' : '/')
            . $path;
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

        if ($response === false) {
            throw new CurlErrorException(curl_error($ch), curl_errno($ch), $ch);
        }

        $httpStatus = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if (200 <= $httpStatus && $httpStatus <= 299) {
            curl_close($ch);
            return json_decode($response, true);
        }

        $message = '';

        if ($httpStatus === 400) {
            try {
                $body = json_decode($response, true, 512, JSON_THROW_ON_ERROR);
                $message = $body['error'] ?? '';
            } catch (JsonException $e) {
                //
            }
        }

        throw new RequestException(
            $message,
            $httpStatus,
            $response,
            $ch
        );
    }

    protected function isSandbox(): bool
    {
        return $this->getEnvironment() === MontonioClient::ENVIRONMENT_SANDBOX;
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
