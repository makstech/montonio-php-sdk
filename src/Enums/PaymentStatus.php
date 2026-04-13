<?php

declare(strict_types=1);

namespace Montonio\Enums;

enum PaymentStatus: string
{
    case Pending = 'PENDING';
    case Paid = 'PAID';
    case Voided = 'VOIDED';
    case PartiallyRefunded = 'PARTIALLY_REFUNDED';
    case Refunded = 'REFUNDED';
    case Abandoned = 'ABANDONED';
    case Authorized = 'AUTHORIZED';
}
