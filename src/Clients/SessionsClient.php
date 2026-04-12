<?php

declare(strict_types=1);

namespace Montonio\Clients;

class SessionsClient extends AbstractClient
{
    /**
     * Create a session for embedded card payments.
     * Returns an array with 'uuid' — pass this to the MontonioCheckout JS SDK.
     */
    public function createSession(): array
    {
        return $this->post('sessions');
    }
}
