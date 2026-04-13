<?php

declare(strict_types=1);

namespace Montonio\Clients\Shipping;

use Montonio\Clients\ShippingAbstractClient;

/**
 * Factory for Montonio Shipping V2 API sub-clients.
 *
 * Access via $client->shipping()->carriers(), ->shippingMethods(), etc.
 *
 * @see https://docs.montonio.com/api/shipping-v2/reference
 */
class ShippingClient extends ShippingAbstractClient
{
    public function carriers(): CarriersClient
    {
        return new CarriersClient(
            $this->getAccessKey(),
            $this->getSecretKey(),
            $this->getEnvironment(),
        );
    }

    public function shippingMethods(): ShippingMethodsClient
    {
        return new ShippingMethodsClient(
            $this->getAccessKey(),
            $this->getSecretKey(),
            $this->getEnvironment(),
        );
    }

    public function shipments(): ShipmentsClient
    {
        return new ShipmentsClient(
            $this->getAccessKey(),
            $this->getSecretKey(),
            $this->getEnvironment(),
        );
    }

    public function labels(): LabelFilesClient
    {
        return new LabelFilesClient(
            $this->getAccessKey(),
            $this->getSecretKey(),
            $this->getEnvironment(),
        );
    }

    public function webhooks(): ShippingWebhooksClient
    {
        return new ShippingWebhooksClient(
            $this->getAccessKey(),
            $this->getSecretKey(),
            $this->getEnvironment(),
        );
    }
}
