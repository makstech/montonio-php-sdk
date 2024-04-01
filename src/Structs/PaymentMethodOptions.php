<?php

declare(strict_types=1);

namespace Montonio\Structs;

class PaymentMethodOptions extends AbstractStruct
{
    protected string $paymentDescription;
    protected string $paymentReference;
    protected string $preferredCountry;
    protected string $preferredProvider;
    protected string $preferredMethod;
    protected string $preferredLocale;
    protected int $period;

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

    /**
     * Used for `paymentInitiation`.
     * Description of the payment that will be relayed to the bank's payment order.
     * If not included, it will default to the value of merchantReference.
     */
    public function getPaymentDescription(): ?string
    {
        return $this->paymentDescription ?? null;
    }

    /**
     * Used for `paymentInitiation`.
     * Description of the payment that will be relayed to the bank's payment order.
     * If not included, it will default to the value of merchantReference.
     */
    public function setPaymentDescription(string $paymentDescription): self
    {
        $this->paymentDescription = $paymentDescription;

        return $this;
    }

    /**
     * Used for `paymentInitiation`.
     *  Structured payment reference number. This is a standardized reference number used for accounting
     *  purposes and will be validated by banks. Do not include if you do not use reference numbers
     *  to link payments in your accounting software. Banks validate this number strictly
     *  and payments will start failing if this number is not formatted correctly.
     */
    public function getPaymentReference(): ?string
    {
        return $this->paymentReference ?? null;
    }

    /**
     * Used for `paymentInitiation`.
     * Structured payment reference number. This is a standardized reference number used for accounting
     * purposes and will be validated by banks. Do not include if you do not use reference numbers
     * to link payments in your accounting software. Banks validate this number strictly
     * and payments will start failing if this number is not formatted correctly.
     */
    public function setPaymentReference(string $paymentReference): self
    {
        $this->paymentReference = $paymentReference;

        return $this;
    }

    /**
     * Used for `cardPayments`.
     * Enables to choose which payment method is shown first by default in the UI - Card payments or Wallets.
     * Defaults to wallet meaning that by default Apple or Google Pay are selected (customer can
     * still choose to enter card details and pay). Available values are wallet, card.
     */
    public function getPreferredMethod(): ?string
    {
        return $this->preferredMethod ?? null;
    }

    /**
     * Used for `cardPayments`.
     * Enables to choose which payment method is shown first by default in the UI - Card payments or Wallets.
     * Defaults to wallet meaning that by default Apple or Google Pay are selected (customer can
     * still choose to enter card details and pay). Available values are wallet, card.
     */
    public function setPreferredMethod(string $preferredMethod): self
    {
        $this->preferredMethod = $preferredMethod;

        return $this;
    }

    /**
     * The preferred language of the payment gateway. Defaults to the Order locale.
     * Available values are de, en, et, fi, lt, lv, pl, ru.
     */
    public function getPreferredLocale(): ?string
    {
        return $this->preferredLocale ?? null;
    }

    /**
     * The preferred language of the payment gateway. Defaults to the Order locale.
     * Available values are de, en, et, fi, lt, lv, pl, ru.
     */
    public function setPreferredLocale(string $preferredLocale): self
    {
        $this->preferredLocale = $preferredLocale;

        return $this;
    }

    /**
     * Used for `bnpl`.
     * The period of the Buy Now Pay Later payment. Can be either 1 to pay next month,
     * or 2 or 3 to split the payment into 2 or 3 monthly instalments.
     */
    public function getPeriod(): ?int
    {
        return $this->period ?? null;
    }

    /**
     * Used for `bnpl`.
     * The period of the Buy Now Pay Later payment. Can be either 1 to pay next month,
     * or 2 or 3 to split the payment into 2 or 3 monthly instalments.
     */
    public function setPeriod(int $period): self
    {
        $this->period = $period;

        return $this;
    }
}
