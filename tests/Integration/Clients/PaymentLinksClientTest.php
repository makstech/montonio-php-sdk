<?php

declare(strict_types=1);

namespace Tests\Integration\Clients;

use Montonio\Structs\CreatePaymentLinkData;
use Tests\Integration\IntegrationTestCase;

class PaymentLinksClientTest extends IntegrationTestCase
{
    public function testCreatePaymentLink(): void
    {
        $data = (new CreatePaymentLinkData())
            ->setDescription('Hello')
            ->setCurrency('EUR')
            ->setAmount(10.00)
            ->setLocale('fi')
            ->setAskAdditionalInfo(true)
            ->setExpiresAt(date('Y-m-d H:i:s', strtotime('+1 hour')));

        $return = $this->getMontonioClient()->paymentLinks()->createPaymentLink($data);

        $this->assertArrayHasKey('uuid', $return);
        $this->assertArrayHasKey('url', $return);
        $this->assertArrayHasKey('shortUrl', $return);
    }

    public function testGetPaymentLink(): void
    {
        $data = (new CreatePaymentLinkData())
            ->setDescription('Get test')
            ->setCurrency('EUR')
            ->setAmount(5.00)
            ->setLocale('en')
            ->setAskAdditionalInfo(false)
            ->setExpiresAt(date('c', strtotime('+1 hour')));

        $created = $this->getMontonioClient()->paymentLinks()->createPaymentLink($data);

        $fetched = $this->getMontonioClient()->paymentLinks()->getPaymentLink($created['uuid']);

        $this->assertSame($created['uuid'], $fetched['uuid']);
    }
}
