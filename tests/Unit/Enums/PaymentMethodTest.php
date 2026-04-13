<?php

declare(strict_types=1);

namespace Tests\Unit\Enums;

use Montonio\Enums\PaymentMethod;
use Montonio\Structs\Payment;
use Tests\BaseTestCase;

class PaymentMethodTest extends BaseTestCase
{
    public function testValues(): void
    {
        $this->assertSame('paymentInitiation', PaymentMethod::PaymentInitiation->value);
        $this->assertSame('cardPayments', PaymentMethod::CardPayments->value);
        $this->assertSame('blik', PaymentMethod::Blik->value);
        $this->assertSame('hirePurchase', PaymentMethod::HirePurchase->value);
        $this->assertSame('bnpl', PaymentMethod::BuyNowPayLater->value);
    }

    public function testSetMethodAcceptsEnum(): void
    {
        $payment = (new Payment())->setMethod(PaymentMethod::Blik);

        $this->assertSame('blik', $payment->getMethod());
    }

    public function testSetMethodAcceptsString(): void
    {
        $payment = (new Payment())->setMethod('paymentInitiation');

        $this->assertSame('paymentInitiation', $payment->getMethod());
    }

    public function testMatchesDeprecatedConstants(): void
    {
        $this->assertSame(Payment::METHOD_PAYMENT_INITIATION, PaymentMethod::PaymentInitiation->value);
        $this->assertSame(Payment::METHOD_CARD, PaymentMethod::CardPayments->value);
        $this->assertSame(Payment::METHOD_BLIK, PaymentMethod::Blik->value);
    }
}
