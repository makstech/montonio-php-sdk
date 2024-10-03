<?php

declare(strict_types=1);

namespace Clients;

use Montonio\Structs\CreatePaymentLinkData;
use Tests\BaseTestCase;

class PaymentLinksClientTest extends BaseTestCase
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
}
