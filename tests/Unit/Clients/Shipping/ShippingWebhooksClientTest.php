<?php

declare(strict_types=1);

namespace Tests\Unit\Clients\Shipping;

use Montonio\Clients\Shipping\ShippingWebhooksClient;
use Montonio\Structs\Shipping\CreateShippingWebhookData;
use Tests\BaseTestCase;

class ShippingWebhooksClientTest extends BaseTestCase
{
    private function createClientMock(): ShippingWebhooksClient
    {
        return $this->getMockBuilder(ShippingWebhooksClient::class)
            ->setConstructorArgs([ACCESS_KEY, SECRET_KEY, 'sandbox'])
            ->onlyMethods(['call'])
            ->getMock();
    }

    public function testCreateWebhook(): void
    {
        $mock = $this->createClientMock();

        $mock->expects($this->once())
            ->method('call')
            ->with(
                'POST',
                $this->stringContains('/webhooks'),
                $this->callback(function ($payload) {
                    $data = json_decode($payload, true);
                    return $data['url'] === 'https://example.com/hook'
                        && $data['enabledEvents'] === ['shipment.registered'];
                }),
            )
            ->willReturn(['id' => 'wh-uuid', 'url' => 'https://example.com/hook']);

        $data = (new CreateShippingWebhookData())
            ->setUrl('https://example.com/hook')
            ->setEnabledEvents(['shipment.registered']);

        $result = $mock->createWebhook($data);

        $this->assertSame('wh-uuid', $result['id']);
    }

    public function testListWebhooks(): void
    {
        $mock = $this->createClientMock();

        $mock->expects($this->once())
            ->method('call')
            ->with(
                'GET',
                $this->stringContains('/webhooks'),
            )
            ->willReturn(['data' => []]);

        $result = $mock->listWebhooks();

        $this->assertSame(['data' => []], $result);
    }

    public function testDeleteWebhook(): void
    {
        $mock = $this->createClientMock();

        $mock->expects($this->once())
            ->method('call')
            ->with(
                'DELETE',
                $this->stringContains('/webhooks/wh-uuid'),
            )
            ->willReturn([]);

        $result = $mock->deleteWebhook('wh-uuid');

        $this->assertSame([], $result);
    }
}
