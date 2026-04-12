<?php

declare(strict_types=1);

namespace Tests\Unit\Structs;

use Montonio\Structs\CreatePaymentLinkData;
use Tests\BaseTestCase;

class CreatePaymentLinkDataTest extends BaseTestCase
{
    public function testAllFields(): void
    {
        $data = (new CreatePaymentLinkData())
            ->setDescription('Test payment')
            ->setCurrency('EUR')
            ->setAmount(10.00)
            ->setLocale('en')
            ->setAskAdditionalInfo(true)
            ->setExpiresAt('2026-12-31T23:59:59Z')
            ->setType('one_time')
            ->setReturnUrl('https://example.com/return')
            ->setMerchantReference('ORDER-123')
            ->setShowShippingOptions(true)
            ->setCustomerCountry('EE');

        $array = $data->toArray();

        $this->assertSame('Test payment', $array['description']);
        $this->assertSame('EUR', $array['currency']);
        $this->assertSame(10.00, $array['amount']);
        $this->assertSame('en', $array['locale']);
        $this->assertTrue($array['askAdditionalInfo']);
        $this->assertSame('2026-12-31T23:59:59Z', $array['expiresAt']);
        $this->assertSame('one_time', $array['type']);
        $this->assertSame('https://example.com/return', $array['returnUrl']);
        $this->assertSame('ORDER-123', $array['merchantReference']);
        $this->assertTrue($array['showShippingOptions']);
        $this->assertSame('EE', $array['customerCountry']);
    }

    public function testConstructFromArray(): void
    {
        $data = new CreatePaymentLinkData([
            'description' => 'From array',
            'currency' => 'PLN',
            'amount' => 50.00,
            'locale' => 'pl',
            'askAdditionalInfo' => false,
            'expiresAt' => '2026-06-01T00:00:00Z',
            'type' => 'reusable',
        ]);

        $this->assertSame('From array', $data->getDescription());
        $this->assertSame('PLN', $data->getCurrency());
        $this->assertSame('reusable', $data->getType());
    }

    public function testNullableNewFields(): void
    {
        $data = new CreatePaymentLinkData();

        $this->assertNull($data->getType());
        $this->assertNull($data->getReturnUrl());
        $this->assertNull($data->getMerchantReference());
        $this->assertNull($data->getShowShippingOptions());
        $this->assertNull($data->getCustomerCountry());
    }
}
