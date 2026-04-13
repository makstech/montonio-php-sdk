<?php

declare(strict_types=1);

namespace Montonio\Structs\Shipping;

use Montonio\Structs\AbstractStruct;

/**
 * Request data for updating a shipment (PATCH — all fields optional).
 *
 * @see https://docs.montonio.com/api/shipping-v2/reference#update-a-shipment
 */
class UpdateShipmentData extends AbstractStruct
{
    protected ShipmentShippingMethod $shippingMethod;
    protected ShippingContact $receiver;
    protected ShippingContact $sender;
    /** @var ShipmentParcel[] */
    protected array $parcels = [];

    public function getShippingMethod(): ?ShipmentShippingMethod
    {
        return $this->shippingMethod ?? null;
    }

    public function setShippingMethod(ShipmentShippingMethod $shippingMethod): self
    {
        $this->shippingMethod = $shippingMethod;

        return $this;
    }

    public function getReceiver(): ?ShippingContact
    {
        return $this->receiver ?? null;
    }

    public function setReceiver(ShippingContact $receiver): self
    {
        $this->receiver = $receiver;

        return $this;
    }

    public function getSender(): ?ShippingContact
    {
        return $this->sender ?? null;
    }

    public function setSender(ShippingContact $sender): self
    {
        $this->sender = $sender;

        return $this;
    }

    public function getParcels(): ?array
    {
        return $this->parcels ?? null;
    }

    /**
     * @param ShipmentParcel[] $parcels
     */
    public function setParcels(array $parcels): self
    {
        foreach ($parcels as $key => $parcel) {
            if (is_array($parcel)) {
                $parcels[$key] = new ShipmentParcel($parcel);
            }
        }

        $this->parcels = $parcels;

        return $this;
    }
}
