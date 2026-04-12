<?php

declare(strict_types=1);

namespace Tests\Integration\Clients;

use Tests\Integration\IntegrationTestCase;

class SessionsClientTest extends IntegrationTestCase
{
    public function testCreateSession(): void
    {
        $response = $this->getMontonioClient()->sessions()->createSession();

        $this->assertArrayHasKey('uuid', $response);
        $this->assertNotEmpty($response['uuid']);
    }
}
