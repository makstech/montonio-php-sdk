<?php

declare(strict_types=1);

namespace Montonio\Clients;

use Montonio\MontonioClient;

/**
 * Base client for the Montonio Payments (Stargate) API.
 *
 * POST requests wrap the payload in a JWT token sent as {"data": "<token>"}.
 * GET requests use a Bearer JWT in the Authorization header.
 *
 * @see https://docs.montonio.com/api/stargate/reference
 */
abstract class PaymentsAbstractClient extends AbstractClient
{
    protected const SANDBOX_URL = 'https://sandbox-stargate.montonio.com/api';
    protected const LIVE_URL = 'https://stargate.montonio.com/api';

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
