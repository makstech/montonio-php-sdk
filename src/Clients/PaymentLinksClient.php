<?php

declare(strict_types=1);

namespace Montonio\Clients;

use Montonio\Structs\CreatePaymentLinkData;

class PaymentLinksClient extends AbstractClient
{
    public function createPaymentLink(CreatePaymentLinkData $data): array
    {
        return $this->post('payment-links', $data->toArray());
    }
}
