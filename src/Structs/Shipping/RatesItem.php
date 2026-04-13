<?php

declare(strict_types=1);

namespace Montonio\Structs\Shipping;

use Montonio\Structs\AbstractStruct;

class RatesItem extends AbstractStruct
{
    protected float $length;
    protected float $width;
    protected float $height;
    protected float $weight;
    protected string $dimensionUnit;
    protected string $weightUnit;
    protected int $quantity;

    public function getLength(): ?float
    {
        return $this->length ?? null;
    }

    public function setLength(float $length): self
    {
        $this->length = $length;

        return $this;
    }

    public function getWidth(): ?float
    {
        return $this->width ?? null;
    }

    public function setWidth(float $width): self
    {
        $this->width = $width;

        return $this;
    }

    public function getHeight(): ?float
    {
        return $this->height ?? null;
    }

    public function setHeight(float $height): self
    {
        $this->height = $height;

        return $this;
    }

    public function getWeight(): ?float
    {
        return $this->weight ?? null;
    }

    public function setWeight(float $weight): self
    {
        $this->weight = $weight;

        return $this;
    }

    public function getDimensionUnit(): ?string
    {
        return $this->dimensionUnit ?? null;
    }

    public function setDimensionUnit(string $dimensionUnit): self
    {
        $this->dimensionUnit = $dimensionUnit;

        return $this;
    }

    public function getWeightUnit(): ?string
    {
        return $this->weightUnit ?? null;
    }

    public function setWeightUnit(string $weightUnit): self
    {
        $this->weightUnit = $weightUnit;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity ?? null;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }
}
