<?php

declare(strict_types=1);

namespace Montonio\Structs;

use Montonio\Structs\Fields\Amount;
use Montonio\Structs\Fields\Currency;

class Payment extends AbstractStruct
{
    use Amount, Currency;

    public const METHOD_PAYMENT_INITIATION = 'paymentInitiation';
    public const METHOD_CARD = 'cardPayments';
    public const METHOD_BLIK = 'blik';
    public const METHOD_HIRE_PURCHASE = 'hirePurchase';
    public const METHOD_BUY_NOW_PAY_LATER = 'bnpl';
    protected string $method;
    protected string $methodDisplay;
    protected PaymentMethodOptions $methodOptions;

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
