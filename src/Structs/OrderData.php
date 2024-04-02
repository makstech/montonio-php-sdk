<?php

declare(strict_types=1);

namespace Montonio\Structs;

class OrderData extends AbstractStruct
{
    public const STATUS_PENDING = 'PENDING';
    public const STATUS_PAID = 'PAID';
    public const STATUS_VOIDED = 'VOIDED';
    public const STATUS_PARTIALLY_REFUNDED = 'PARTIALLY_REFUNDED';
    public const STATUS_REFUNDED = 'REFUNDED';
    public const STATUS_ABANDONED = 'ABANDONED';
    public const STATUS_AUTHORIZED = 'AUTHORIZED';

    protected string $merchantReference;
    protected string $returnUrl;
    protected string $notificationUrl;
    protected float $grandTotal;
    protected string $currency;
    protected string $locale;
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
     * The URL to send a webhook notification about Order updates, e.g when a payment is completed.
     */
    public function getNotificationUrl(): ?string
    {
        return $this->notificationUrl ?? null;
    }

    /**
     * The URL to send a webhook notification about Order updates, e.g when a payment is completed.
     */
    public function setNotificationUrl(string $notificationUrl): self
    {
        $this->notificationUrl = $notificationUrl;

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
     * Payment currency. Currently EUR and PLN are supported depending on the payment method provided.
     */
    public function getCurrency(): ?string
    {
        return $this->currency ?? null;
    }

    /**
     * Payment currency. Currently EUR and PLN are supported depending on the payment method provided.
     */
    public function setCurrency(string $currency): self
    {
        $this->currency = $currency;

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
