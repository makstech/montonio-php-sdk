<?php

declare(strict_types=1);

namespace Montonio\Structs\Fields;

trait PreferredProvider
{
    protected string $preferredCountry;
    protected string $preferredProvider;

    /**
     * Used for `paymentInitiation`.
     * The bank that the customer chose for this payment if you allow them to select their bank of choice
     * in your checkout. Leave this blank to let the customer choose their bank in our interface.
     * The value can be found in the code parameters of the response. It is highly recommended
     * you send this to us as it improves the customer experience and saves time at checkout.
     */
    public function getPreferredProvider(): ?string
    {
        return $this->preferredProvider ?? null;
    }

    /**
     * Used for `paymentInitiation`.
     * The bank that the customer chose for this payment if you allow them to select their bank of choice
     * in your checkout. Leave this blank to let the customer choose their bank in our interface.
     * The value can be found in the code parameters of the response. It is highly recommended
     * you send this to us as it improves the customer experience and saves time at checkout.
     */
    public function setPreferredProvider(string $preferredProvider): self
    {
        $this->preferredProvider = $preferredProvider;

        return $this;
    }

    /**
     * Used for `paymentInitiation`.
     * The preferred country for the methods list of the payment gateway. Defaults to the merchant's country.
     * Available values are EE, LV, LT, FI, PL, DE.
     */
    public function getPreferredCountry(): ?string
    {
        return $this->preferredCountry ?? null;
    }

    /**
     * Used for `paymentInitiation`.
     * The preferred country for the methods list of the payment gateway. Defaults to the merchant's country.
     * Available values are EE, LV, LT, FI, PL, DE.
     */
    public function setPreferredCountry(string $preferredCountry): self
    {
        $this->preferredCountry = $preferredCountry;

        return $this;
    }
}
