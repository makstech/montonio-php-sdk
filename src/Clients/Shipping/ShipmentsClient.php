<?php

declare(strict_types=1);

namespace Montonio\Clients\Shipping;

use Montonio\Clients\ShippingAbstractClient;
use Montonio\Structs\Shipping\CreateShipmentData;
use Montonio\Structs\Shipping\UpdateShipmentData;

/**
 * @see https://docs.montonio.com/api/shipping-v2/guides/shipments
 *
 */
class ShipmentsClient extends ShippingAbstractClient
{
    /**
     * Create a new shipment.
     *
     * Use synchronous: true to wait for carrier registration before the response.
     */
    public function createShipment(CreateShipmentData $data): array
    {
        return $this->post('shipments', $data->toArray());
    }

    /**
     * Update an existing shipment (PATCH — only provided fields are changed).
     */
    public function updateShipment(string $shipmentId, UpdateShipmentData $data): array
    {
        return $this->patch('shipments/' . $shipmentId, $data->toArray());
    }

    public function getShipment(string $shipmentId): array
    {
        return $this->get('shipments/' . $shipmentId);
    }
}
