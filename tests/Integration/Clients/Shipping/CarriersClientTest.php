<?php

declare(strict_types=1);

namespace Tests\Integration\Clients\Shipping;

use Tests\Integration\IntegrationTestCase;

class CarriersClientTest extends IntegrationTestCase
{
    public function testGetCarriers(): void
    {
        $response = $this->getMontonioClient()->shipping()->carriers()->getCarriers();

        $this->assertArrayHasKey('carriers', $response);
        $this->assertIsArray($response['carriers']);
    }
}
