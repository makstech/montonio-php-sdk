<?php

declare(strict_types=1);

namespace Montonio\Clients;

use Montonio\Structs\OrderData;

class OrdersClient extends AbstractClient
{
    public function createOrder(OrderData $paymentData): array
    {
        return $this->post('orders', $paymentData->toArray());
    }
}
