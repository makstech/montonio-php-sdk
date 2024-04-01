<?php

declare(strict_types=1);

namespace Montonio\Structs;

class Payment extends AbstractStruct
{
    public const METHOD_PAYMENT_INITIATION = 'paymentInitiation';
    public const METHOD_CARD = 'cardPayments';
    public const METHOD_BLIK = 'blik';
    public const METHOD_HIRE_PURCHASE = 'hirePurchase';
    public const METHOD_BUY_NOW_PAY_LATER = 'bnpl';

    protected float $amount;
    protected string $currency;
    protected string $method;
    protected string $methodDisplay;
    protected PaymentMethodOptions $methodOptions;

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    /**
     * The amount to charge. This is the total amount of the order, including tax and shipping.
     */
    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    /**
     * The currency of the order. This is a 3-letter ISO currency code.
     */
    public function setCurrency(string $currency): self
    {
        $this->currency = $currency;

        return $this;
    }

    public function getMethod(): ?string
    {
        return $this->method;
    }

    /**
     * The Identifier of the Montonio Payment Method.
     * Use one of predefined const's defined in this class.
     */
    public function setMethod(string $method): self
    {
        $this->method = $method;

        return $this;
    }

    public function getMethodDisplay(): ?string
    {
        return $this->methodDisplay;
    }

    /**
     * The Payment Method's title as is shown to the customer at checkout.
     */
    public function setMethodDisplay(string $methodDisplay): self
    {
        $this->methodDisplay = $methodDisplay;

        return $this;
    }

    public function getMethodOptions(): ?PaymentMethodOptions
    {
        return $this->methodOptions;
    }

    /**
     * Additional options for the payment method.
     */
    public function setMethodOptions(PaymentMethodOptions $methodOptions): self
    {
        $this->methodOptions = $methodOptions;

        return $this;
    }
}
