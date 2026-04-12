<?php

declare(strict_types=1);

namespace Montonio\Clients;

class StoresClient extends PaymentsAbstractClient
{
    public function getPaymentMethods(): array
    {
        return $this->get('stores/payment-methods');
    }
}
