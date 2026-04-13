<?php

declare(strict_types=1);

namespace Montonio\Structs\Shipping;

use Montonio\Structs\AbstractStruct;

/**
 * Request data for creating a shipment.
 *
 * @see https://docs.montonio.com/api/shipping-v2/reference#create-shipment
 */
class CreateShipmentData extends AbstractStruct
{
    protected ShipmentShippingMethod $shippingMethod;
    protected ShippingContact $receiver;
    protected ShippingContact $sender;
    /** @var ShipmentParcel[] */
    protected array $parcels = [];
    /** @var ShipmentProduct[] */
    protected array $products = [];
    protected string $merchantReference;
    protected string $montonioOrderUuid;
    protected string $orderComment;
    protected bool $synchronous;

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

    public function getProducts(): ?array
    {
        return $this->products ?? null;
    }

    /**
     * @param ShipmentProduct[] $products
     */
    public function setProducts(array $products): self
    {
        foreach ($products as $key => $product) {
            if (is_array($product)) {
                $products[$key] = new ShipmentProduct($product);
            }
        }

        $this->products = $products;

        return $this;
    }

    public function getMerchantReference(): ?string
    {
        return $this->merchantReference ?? null;
    }

    public function setMerchantReference(string $merchantReference): self
    {
        $this->merchantReference = $merchantReference;

        return $this;
    }

    public function getMontonioOrderUuid(): ?string
    {
        return $this->montonioOrderUuid ?? null;
    }

    public function setMontonioOrderUuid(string $montonioOrderUuid): self
    {
        $this->montonioOrderUuid = $montonioOrderUuid;

        return $this;
    }

    public function getOrderComment(): ?string
    {
        return $this->orderComment ?? null;
    }

    public function setOrderComment(string $orderComment): self
    {
        $this->orderComment = $orderComment;

        return $this;
    }

    public function getSynchronous(): ?bool
    {
        return $this->synchronous ?? null;
    }

    public function setSynchronous(bool $synchronous): self
    {
        $this->synchronous = $synchronous;

        return $this;
    }
}
