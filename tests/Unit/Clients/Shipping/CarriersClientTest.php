<?php

declare(strict_types=1);

namespace Tests\Unit\Clients\Shipping;

use Montonio\Clients\Shipping\CarriersClient;
use Tests\BaseTestCase;

class CarriersClientTest extends BaseTestCase
{
    public function testGetCarriers(): void
    {
        $mock = $this->getMockBuilder(CarriersClient::class)
            ->setConstructorArgs([ACCESS_KEY, SECRET_KEY, 'sandbox'])
            ->onlyMethods(['call'])
            ->getMock();

        $mock->expects($this->once())
            ->method('call')
            ->with(
                'GET',
                $this->stringContains('/carriers'),
                null,
                $this->callback(fn ($headers) => is_array($headers))
            )
            ->willReturn(['carriers' => []]);

        $result = $mock->getCarriers();

        $this->assertSame(['carriers' => []], $result);
    }
}
