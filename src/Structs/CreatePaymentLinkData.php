<?php

declare(strict_types=1);

namespace Montonio\Structs;

use Montonio\Structs\Fields\Amount;
use Montonio\Structs\Fields\Currency;
use Montonio\Structs\Fields\Locale;
use Montonio\Structs\Fields\NotificationUrl;
use Montonio\Structs\Fields\PaymentReference;
use Montonio\Structs\Fields\PreferredProvider;

class CreatePaymentLinkData extends AbstractStruct
{
    use Amount, Currency, Locale, NotificationUrl, PaymentReference, PreferredProvider;

    protected string $description;
    protected bool $askAdditionalInfo;
    protected string $expiresAt;
    protected string $type;
    protected string $returnUrl;
    protected string $merchantReference;
    protected bool $showShippingOptions;
    protected string $customerCountry;

    /**
     * Description of the payment link that is shown on the payment page
     */
    public function getDescription(): ?string
    {
        return $this->description ?? null;
    }

    /**
     * Description of the payment link that is shown on the payment page
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * If true, the payment page will ask for additional information from the payer (eg. first name, last name, etc.).
     * If false, the payment page will not ask for additional information from the payer
     */
    public function getAskAdditionalInfo(): ?bool
    {
        return $this->askAdditionalInfo ?? null;
    }

    /**
     * If true, the payment page will ask for additional information from the payer (eg. first name, last name, etc.).
     * If false, the payment page will not ask for additional information from the payer
     */
    public function setAskAdditionalInfo(bool $askAdditionalInfo): self
    {
        $this->askAdditionalInfo = $askAdditionalInfo;

        return $this;
    }

    /**
     * Timestamp in ISO 8601 format. The time when we will no longer accept any orders for this payment-link.
     */
    public function getExpiresAt(): ?string
    {
        return $this->expiresAt ?? null;
    }

    /**
     * Timestamp in ISO 8601 format. The time when we will no longer accept any orders for this payment-link.
     */
    public function setExpiresAt(string $expiresAt): self
    {
        $this->expiresAt = $expiresAt;

        return $this;
    }

    /**
     * Payment link type. Available values: 'one_time', 'reusable'. Defaults to 'reusable'.
     */
    public function getType(): ?string
    {
        return $this->type ?? null;
    }

    /**
     * Payment link type. Available values: 'one_time', 'reusable'. Defaults to 'reusable'.
     */
    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * The URL where the customer will be redirected after payment.
     */
    public function getReturnUrl(): ?string
    {
        return $this->returnUrl ?? null;
    }

    /**
     * The URL where the customer will be redirected after payment.
     */
    public function setReturnUrl(string $returnUrl): self
    {
        $this->returnUrl = $returnUrl;

        return $this;
    }

    /**
     * Your unique order reference. Only for 'one_time' links.
     */
    public function getMerchantReference(): ?string
    {
        return $this->merchantReference ?? null;
    }

    /**
     * Your unique order reference. Only for 'one_time' links.
     */
    public function setMerchantReference(string $merchantReference): self
    {
        $this->merchantReference = $merchantReference;

        return $this;
    }

    /**
     * If true, shows shipping options section. Requires askAdditionalInfo=true and customerCountry.
     */
    public function getShowShippingOptions(): ?bool
    {
        return $this->showShippingOptions ?? null;
    }

    /**
     * If true, shows shipping options section. Requires askAdditionalInfo=true and customerCountry.
     */
    public function setShowShippingOptions(bool $showShippingOptions): self
    {
        $this->showShippingOptions = $showShippingOptions;

        return $this;
    }

    /**
     * ISO 3166-1 alpha-2 country code. Required when showShippingOptions is true.
     */
    public function getCustomerCountry(): ?string
    {
        return $this->customerCountry ?? null;
    }

    /**
     * ISO 3166-1 alpha-2 country code. Required when showShippingOptions is true.
     */
    public function setCustomerCountry(string $customerCountry): self
    {
        $this->customerCountry = $customerCountry;

        return $this;
    }
}
