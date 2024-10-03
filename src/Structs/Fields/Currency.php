<?php

declare(strict_types=1);

namespace Montonio\Structs\Fields;

trait Currency
{
    protected string $currency;

    /**
     * Payment currency. This is a 3-letter ISO currency code.
     */
    public function getCurrency(): ?string
    {
        return $this->currency ?? null;
    }

    /**
     * Payment currency. This is a 3-letter ISO currency code.
     */
    public function setCurrency(string $currency): self
    {
        $this->currency = $currency;

        return $this;
    }
}
