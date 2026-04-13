<?php

declare(strict_types=1);

namespace Montonio\Structs\Shipping;

use Montonio\Structs\AbstractStruct;

class AdditionalServiceParams extends AbstractStruct
{
    protected float $amount;

    public function getAmount(): ?float
    {
        return $this->amount ?? null;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }
}
