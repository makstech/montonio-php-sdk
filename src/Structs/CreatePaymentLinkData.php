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
}
