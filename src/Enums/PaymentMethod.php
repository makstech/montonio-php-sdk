<?php

declare(strict_types=1);

namespace Montonio\Enums;

enum PaymentMethod: string
{
    case PaymentInitiation = 'paymentInitiation';
    case CardPayments = 'cardPayments';
    case Blik = 'blik';
    case HirePurchase = 'hirePurchase';
    case BuyNowPayLater = 'bnpl';
}
