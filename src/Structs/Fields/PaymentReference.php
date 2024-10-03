<?php

declare(strict_types=1);

namespace Montonio\Structs\Fields;

trait PaymentReference
{
    protected string $paymentReference;

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
}
