<?php

declare(strict_types=1);

namespace Montonio\Structs\Fields;

trait Amount
{
    protected float $amount;

    /**
     * The amount to charge. This is the total amount of the order, including tax and shipping.
     */
    public function getAmount(): ?float
    {
        return $this->amount ?? null;
    }

    /**
     * The amount to charge. This is the total amount of the order, including tax and shipping.
     */
    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }
}
