<?php

declare(strict_types=1);

namespace Montonio\Structs\Fields;

trait Locale
{
    protected string $locale;

    /**
     * The preferred language of the payment gateway. Defaults to the merchant country's official language.
     * Available values are de, en, et, fi, lt, lv, pl, ru.
     */
    public function getLocale(): ?string
    {
        return $this->locale ?? null;
    }

    /**
     * The preferred language of the payment gateway. Defaults to the merchant country's official language.
     * Available values are de, en, et, fi, lt, lv, pl, ru.
     */
    public function setLocale(string $locale): self
    {
        $this->locale = $locale;

        return $this;
    }
}
