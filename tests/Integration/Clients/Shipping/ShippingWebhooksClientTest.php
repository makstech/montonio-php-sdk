<?php

declare(strict_types=1);

namespace Tests\Integration\Clients\Shipping;

use Montonio\Structs\Shipping\CreateShippingWebhookData;
use Tests\Integration\IntegrationTestCase;

class ShippingWebhooksClientTest extends IntegrationTestCase
{
    public function testCreateListAndDeleteWebhook(): void
    {
        $client = $this->getMontonioClient()->shipping()->webhooks();

        // Create webhook
        $data = (new CreateShippingWebhookData())
            ->setUrl('https://example.com/sdk-test-webhook-' . time())
            ->setEnabledEvents(['shipment.registered']);

        $created = $client->createWebhook($data);

        $this->assertArrayHasKey('id', $created);
        $this->assertArrayHasKey('url', $created);
        $this->assertArrayHasKey('enabledEvents', $created);

        // List webhooks
        $list = $client->listWebhooks();

        $this->assertArrayHasKey('data', $list);
        $this->assertIsArray($list['data']);

        // Delete webhook (cleanup)
        $client->deleteWebhook($created['id']);

        // Verify deletion by listing again
        $listAfter = $client->listWebhooks();
        $ids = array_column($listAfter['data'], 'id');
        $this->assertNotContains($created['id'], $ids);
    }
}
