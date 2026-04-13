<?php

declare(strict_types=1);

namespace Montonio\Structs\Shipping;

use Montonio\Structs\AbstractStruct;

class ShipmentParcel extends AbstractStruct
{
    protected float $weight;
    protected float $height;
    protected float $width;
    protected float $length;

    public function getWeight(): ?float
    {
        return $this->weight ?? null;
    }

    public function setWeight(float $weight): self
    {
        $this->weight = $weight;

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

    public function getWidth(): ?float
    {
        return $this->width ?? null;
    }

    public function setWidth(float $width): self
    {
        $this->width = $width;

        return $this;
    }

    public function getLength(): ?float
    {
        return $this->length ?? null;
    }

    public function setLength(float $length): self
    {
        $this->length = $length;

        return $this;
    }
}
