<?php

declare(strict_types=1);

namespace Montonio\Structs;

class LineItem extends AbstractStruct
{
    protected string $name;
    protected int $quantity = 1;
    protected float $finalPrice;

    public function getName(): ?string
    {
        return $this->name ?? null;
    }

    /**
     * The line item's name.
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity ?? null;
    }

    /**
     * Quantity of the product.
     */
    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getFinalPrice(): ?float
    {
        return $this->finalPrice ?? null;
    }

    /**
     * The product's sale price (tax included). It would make sense if all line item `finalPrice x quantity`'s
     * added up would amount to the `grandTotal` of the order, however this is not mandatory.
     */
    public function setFinalPrice(float $finalPrice): self
    {
        $this->finalPrice = $finalPrice;

        return $this;
    }
}
