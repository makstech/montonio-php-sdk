<?php

declare(strict_types=1);

namespace Tests\Unit\Structs\Shipping;

use Montonio\Structs\Shipping\CreateShippingWebhookData;
use Tests\BaseTestCase;

class CreateShippingWebhookDataTest extends BaseTestCase
{
    public function testFluentSetters(): void
    {
        $data = (new CreateShippingWebhookData())
            ->setUrl('https://example.com/webhook')
            ->setEnabledEvents(['shipment.registered', 'shipment.statusUpdated']);

        $this->assertSame('https://example.com/webhook', $data->getUrl());
        $this->assertSame(['shipment.registered', 'shipment.statusUpdated'], $data->getEnabledEvents());
    }

    public function testToArray(): void
    {
        $data = (new CreateShippingWebhookData())
            ->setUrl('https://example.com/webhook')
            ->setEnabledEvents(['shipment.registered']);

        $array = $data->toArray();

        $this->assertSame('https://example.com/webhook', $array['url']);
        $this->assertSame(['shipment.registered'], $array['enabledEvents']);
    }

    public function testNullableGetters(): void
    {
        $data = new CreateShippingWebhookData();

        $this->assertNull($data->getUrl());
    }
}
