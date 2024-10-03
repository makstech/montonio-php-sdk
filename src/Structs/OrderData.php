<?php

declare(strict_types=1);

namespace Montonio\Structs;

use Montonio\Structs\Fields\Currency;
use Montonio\Structs\Fields\Locale;
use Montonio\Structs\Fields\NotificationUrl;

class OrderData extends AbstractStruct
{
    use Currency, Locale, NotificationUrl;

    public const STATUS_PENDING = 'PENDING';
    public const STATUS_PAID = 'PAID';
    public const STATUS_VOIDED = 'VOIDED';
    public const STATUS_PARTIALLY_REFUNDED = 'PARTIALLY_REFUNDED';
    public const STATUS_REFUNDED = 'REFUNDED';
    public const STATUS_ABANDONED = 'ABANDONED';
    public const STATUS_AUTHORIZED = 'AUTHORIZED';

    protected string $merchantReference;
    protected string $returnUrl;
    protected float $grandTotal;
    protected Payment $payment;
    protected int $exp;
    /** @var LineItem[] */
    protected array $lineItems = [];
    protected Address $billingAddress;
    protected Address $shippingAddress;

    /**
     * The order reference in the merchant's system (e.g. the WooCommerce Order ID).
     */
    public function getMerchantReference(): ?string
    {
        return $this->merchantReference ?? null;
    }

    /**
     * The order reference in the merchant's system (e.g. the WooCommerce Order ID).
     */
    public function setMerchantReference(string $merchantReference): self
    {
        $this->merchantReference = $merchantReference;

        return $this;
    }

    /**
     * The URL where the customer will be redirected back to after completing or cancelling a payment.
     */
    public function getReturnUrl(): ?string
    {
        return $this->returnUrl ?? null;
    }

    /**
     * The URL where the customer will be redirected back to after completing or cancelling a payment.
     */
    public function setReturnUrl(string $returnUrl): self
    {
        $this->returnUrl = $returnUrl;

        return $this;
    }

    /**
     * Order grand total up to 2 decimal places (e.g 19.99).
     */
    public function getGrandTotal(): ?float
    {
        return $this->grandTotal ?? null;
    }

    /**
     * Order grand total up to 2 decimal places (e.g 19.99).
     */
    public function setGrandTotal(float $grandTotal): self
    {
        $this->grandTotal = $grandTotal;

        return $this;
    }

    /**
     * The payment method to use.
     */
    public function getPayment(): ?Payment
    {
        return $this->payment ?? null;
    }

    /**
     * The payment method to use.
     */
    public function setPayment(Payment $payment): self
    {
        $this->payment = $payment;

        return $this;
    }

    public function getExp(): ?int
    {
        return $this->exp ?? null;
    }

    public function setExp(int $exp): self
    {
        $this->exp = $exp;

        return $this;
    }

    /**
     * The customer's billing address.
     */
    public function getBillingAddress(): ?Address
    {
        return $this->billingAddress ?? null;
    }

    /**
     * The customer's billing address.
     */
    public function setBillingAddress(Address $billingAddress): self
    {
        $this->billingAddress = $billingAddress;

        return $this;
    }

    /**
     * The customer's shipping address.
     */
    public function getShippingAddress(): ?Address
    {
        return $this->shippingAddress ?? null;
    }

    /**
     * The customer's shipping address.
     */
    public function setShippingAddress(Address $shippingAddress): self
    {
        $this->shippingAddress = $shippingAddress;

        return $this;
    }

    /**
     * The list of items in the order.
     */
    public function getLineItems(): ?array
    {
        return $this->lineItems ?? null;
    }

    /**
     * The list of items in the order.
     * @param LineItem[] $lineItems
     */
    public function setLineItems(array $lineItems): self
    {
        foreach ($lineItems as $key => $lineItem) {
            if (is_array($lineItem)) {
                $lineItems[$key] = new LineItem($lineItem);
            }
        }

        $this->lineItems = $lineItems;

        return $this;
    }

    public function addLineItem(LineItem $lineItem): self
    {
        $this->lineItems[] = $lineItem;

        return $this;
    }
}
