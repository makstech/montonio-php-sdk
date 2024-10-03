<?php

declare(strict_types=1);

namespace Montonio\Structs;

use Montonio\Structs\Fields\PaymentReference;
use Montonio\Structs\Fields\PreferredProvider;

class PaymentMethodOptions extends AbstractStruct
{
    use PreferredProvider, PaymentReference;

    protected string $paymentDescription;
    protected string $preferredMethod;
    protected string $preferredLocale;
    protected int $period;

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
