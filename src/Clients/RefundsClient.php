<?php

declare(strict_types=1);

namespace Montonio\Clients;

use Montonio\Structs\CreateRefundData;

class RefundsClient extends PaymentsAbstractClient
{
    public function createRefund(CreateRefundData $data): array
    {
        return $this->post('refunds', $data->toArray());
    }
}
