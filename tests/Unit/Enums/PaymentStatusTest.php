<?php

declare(strict_types=1);

namespace Tests\Unit\Enums;

use Montonio\Enums\PaymentStatus;
use Montonio\Structs\OrderData;
use Tests\BaseTestCase;

class PaymentStatusTest extends BaseTestCase
{
    public function testValues(): void
    {
        $this->assertSame('PENDING', PaymentStatus::Pending->value);
        $this->assertSame('PAID', PaymentStatus::Paid->value);
        $this->assertSame('VOIDED', PaymentStatus::Voided->value);
        $this->assertSame('PARTIALLY_REFUNDED', PaymentStatus::PartiallyRefunded->value);
        $this->assertSame('REFUNDED', PaymentStatus::Refunded->value);
        $this->assertSame('ABANDONED', PaymentStatus::Abandoned->value);
        $this->assertSame('AUTHORIZED', PaymentStatus::Authorized->value);
    }

    public function testMatchesDeprecatedConstants(): void
    {
        $this->assertSame(OrderData::STATUS_PENDING, PaymentStatus::Pending->value);
        $this->assertSame(OrderData::STATUS_PAID, PaymentStatus::Paid->value);
        $this->assertSame(OrderData::STATUS_ABANDONED, PaymentStatus::Abandoned->value);
    }
}
