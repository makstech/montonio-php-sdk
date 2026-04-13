<?php

declare(strict_types=1);

namespace Montonio\Clients;

use Montonio\MontonioClient;

/**
 * Base client for the Montonio Shipping V2 API.
 *
 * Unlike the Payments (Stargate) API, all Shipping requests use Bearer JWT auth
 * and send plain JSON bodies (not JWT-wrapped).
 *
 * @see https://docs.montonio.com/api/shipping-v2/reference
 */
abstract class ShippingAbstractClient extends AbstractClient
{
    protected const SANDBOX_URL = 'https://sandbox-shipping.montonio.com/api/v2';
    protected const LIVE_URL = 'https://shipping.montonio.com/api/v2';

    protected function get(string $url, array $queryParams = []): array
    {
        $fullUrl = $this->getUrl($url);

        if (!empty($queryParams)) {
            $fullUrl .= '?' . http_build_query($queryParams);
        }

        return $this->call(
            'GET',
            $fullUrl,
            null,
            [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $this->generateToken(),
            ],
        );
    }

    protected function post(string $url, array $payload = [], array $queryParams = []): array
    {
        $fullUrl = $this->getUrl($url);

        if (!empty($queryParams)) {
            $fullUrl .= '?' . http_build_query($queryParams);
        }

        return $this->call(
            'POST',
            $fullUrl,
            json_encode($payload),
            [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $this->generateToken(),
            ],
        );
    }

    protected function patch(string $url, array $payload = []): array
    {
        return $this->call(
            'PATCH',
            $this->getUrl($url),
            json_encode($payload),
            [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $this->generateToken(),
            ],
        );
    }

    protected function delete(string $url): array
    {
        return $this->call(
            'DELETE',
            $this->getUrl($url),
            null,
            [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $this->generateToken(),
            ],
        );
    }

    protected function getUrl(string $path): string
    {
        return ($this->isSandbox() ? static::SANDBOX_URL : static::LIVE_URL)
            . (str_starts_with($path, '/') ? '' : '/')
            . $path;
    }

    protected function isSandbox(): bool
    {
        return $this->getEnvironment() === MontonioClient::ENVIRONMENT_SANDBOX;
    }
}
