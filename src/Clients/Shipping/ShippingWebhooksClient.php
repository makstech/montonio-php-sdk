<?php

declare(strict_types=1);

namespace Montonio\Clients\Shipping;

use Montonio\Clients\ShippingAbstractClient;
use Montonio\Structs\Shipping\CreateShippingWebhookData;

/**
 * Manage shipping webhooks for receiving status updates.
 *
 * Maximum 10 webhooks per store.
 *
 * @see https://docs.montonio.com/api/shipping-v2/guides/webhooks
 */
class ShippingWebhooksClient extends ShippingAbstractClient
{
    /**
     * Create a webhook to subscribe to shipping events.
     *
     * Available events: shipment.registered, shipment.registrationFailed,
     * shipment.labelsCreated, shipment.statusUpdated, labelFile.ready, labelFile.creationFailed
     */
    public function createWebhook(CreateShippingWebhookData $data): array
    {
        return $this->post('webhooks', $data->toArray());
    }

    public function listWebhooks(): array
    {
        return $this->get('webhooks');
    }

    public function deleteWebhook(string $webhookId): array
    {
        return $this->delete('webhooks/' . $webhookId);
    }
}
