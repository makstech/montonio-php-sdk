<?php

declare(strict_types=1);

namespace Clients;

use Montonio\Exception\RequestException;
use Montonio\Structs\CreatePaymentIntentDraftData;
use Montonio\Structs\Payment;
use Tests\BaseTestCase;

class PaymentIntentsClientTest extends BaseTestCase
{
    public function testCreateDraft(): void
    {
        $data = (new CreatePaymentIntentDraftData())
            ->setMethod(Payment::METHOD_CARD);

        $response = $this->getMontonioClient()->paymentIntents()->createDraft($data);

        $this->assertArrayHasKey('stripePublicKey', $response);
        $this->assertArrayHasKey('stripeClientSecret', $response);
        $this->assertArrayHasKey('onBehalfOf', $response);
        $this->assertArrayHasKey('uuid', $response);
    }

    public function testCreateDraft_fails_missingRequiredData(): void
    {
        $this->expectException(RequestException::class);

        $response = $this->getMontonioClient()->paymentIntents()->createDraft(new CreatePaymentIntentDraftData());
    }
}
