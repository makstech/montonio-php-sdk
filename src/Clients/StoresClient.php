<?php

declare(strict_types=1);

namespace Montonio\Clients;

class StoresClient extends AbstractClient
{
    public function getPaymentMethods(): array
    {
        return $this->get('stores/payment-methods');
    }
}
