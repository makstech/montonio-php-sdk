<?php

declare(strict_types=1);

namespace Tests\Unit\Clients\Shipping;

use Montonio\Clients\Shipping\CarriersClient;
use Montonio\Clients\Shipping\LabelFilesClient;
use Montonio\Clients\Shipping\ShipmentsClient;
use Montonio\Clients\Shipping\ShippingClient;
use Montonio\Clients\Shipping\ShippingMethodsClient;
use Montonio\Clients\Shipping\ShippingWebhooksClient;
use Tests\BaseTestCase;

class ShippingClientTest extends BaseTestCase
{
    public function testGetShippingClient(): void
    {
        $client = $this->getMontonioClient()->shipping();

        $this->assertInstanceOf(ShippingClient::class, $client);
    }

    public function testGetCarriersClient(): void
    {
        $client = $this->getMontonioClient()->shipping()->carriers();

        $this->assertInstanceOf(CarriersClient::class, $client);
    }

    public function testGetShippingMethodsClient(): void
    {
        $client = $this->getMontonioClient()->shipping()->shippingMethods();

        $this->assertInstanceOf(ShippingMethodsClient::class, $client);
    }

    public function testGetShipmentsClient(): void
    {
        $client = $this->getMontonioClient()->shipping()->shipments();

        $this->assertInstanceOf(ShipmentsClient::class, $client);
    }

    public function testGetLabelFilesClient(): void
    {
        $client = $this->getMontonioClient()->shipping()->labels();

        $this->assertInstanceOf(LabelFilesClient::class, $client);
    }

    public function testGetShippingWebhooksClient(): void
    {
        $client = $this->getMontonioClient()->shipping()->webhooks();

        $this->assertInstanceOf(ShippingWebhooksClient::class, $client);
    }
}
