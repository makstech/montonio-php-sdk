<?php

declare(strict_types=1);

namespace Tests\Integration\Clients;

use CurlHandle;
use Montonio\Exception\ApiException;
use Montonio\Structs\CreatePaymentIntentDraftData;
use Montonio\Structs\Payment;
use Tests\Integration\IntegrationTestCase;

class PaymentIntentsClientTest extends IntegrationTestCase
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
            $this->getMontonioClient()->paymentIntents()->createDraft(new CreatePaymentIntentDraftData());
        } catch (ApiException $e) {
        } finally {
            $this->assertInstanceOf(ApiException::class, $e);
            $this->assertJson($e->getResponseBody());
            $this->assertInstanceOf(CurlHandle::class, $e->getCurlHandle());
        }
    }
}
