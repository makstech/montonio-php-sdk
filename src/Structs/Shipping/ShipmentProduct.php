<?php

declare(strict_types=1);

namespace Montonio\Structs\Shipping;

use Montonio\Structs\AbstractStruct;

class ShipmentProduct extends AbstractStruct
{
    protected string $sku;
    protected string $name;
    protected float $quantity;
    protected string $barcode;
    protected float $price;
    protected string $currency;
    protected array $attributes;
    protected string $imageUrl;
    protected string $storeProductUrl;
    protected string $description;

    public function getSku(): ?string
    {
        return $this->sku ?? null;
    }

    public function setSku(string $sku): self
    {
        $this->sku = $sku;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name ?? null;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getQuantity(): ?float
    {
        return $this->quantity ?? null;
    }

    public function setQuantity(float $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getBarcode(): ?string
    {
        return $this->barcode ?? null;
    }

    public function setBarcode(string $barcode): self
    {
        $this->barcode = $barcode;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price ?? null;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getCurrency(): ?string
    {
        return $this->currency ?? null;
    }

    public function setCurrency(string $currency): self
    {
        $this->currency = $currency;

        return $this;
    }

    public function getAttributes(): ?array
    {
        return $this->attributes ?? null;
    }

    public function setAttributes(array $attributes): self
    {
        $this->attributes = $attributes;

        return $this;
    }

    public function getImageUrl(): ?string
    {
        return $this->imageUrl ?? null;
    }

    public function setImageUrl(string $imageUrl): self
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }

    public function getStoreProductUrl(): ?string
    {
        return $this->storeProductUrl ?? null;
    }

    public function setStoreProductUrl(string $storeProductUrl): self
    {
        $this->storeProductUrl = $storeProductUrl;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description ?? null;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
