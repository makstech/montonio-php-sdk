<?php

declare(strict_types=1);

namespace Montonio\Clients;

use Montonio\Structs\CreatePaymentIntentDraftData;

class PaymentIntentsClient extends PaymentsAbstractClient
{
    public function createDraft(CreatePaymentIntentDraftData $data): array
    {
        return $this->post('payment-intents/draft', $data->toArray());
    }
}
