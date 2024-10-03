<?php

declare(strict_types=1);

namespace Clients;

use CurlHandle;
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
        try {
            $response = $this->getMontonioClient()->paymentIntents()->createDraft(new CreatePaymentIntentDraftData());
        } catch (RequestException $e) {
        } finally {
            $this->assertInstanceOf(RequestException::class, $e);
            $this->assertJson($e->getResponse());
            $this->assertInstanceOf(CurlHandle::class, $e->curlHandle());
        }
    }
}
