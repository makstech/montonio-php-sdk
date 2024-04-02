<?php

declare(strict_types=1);

namespace Tests\Unit\Structs;

use Montonio\Structs\Address;
use Montonio\Structs\LineItem;
use Montonio\Structs\OrderData;
use Montonio\Structs\Payment;
use Tests\BaseTestCase;

class OrderDataTest extends BaseTestCase
{
    public function testFluentSettersAndGetters(): void
    {
        $data = new OrderData([
            'locale' => 'lv',
        ]);

        $this->assertSame('lv', $data->getLocale());

        $address = (new Address())
            ->setFirstName('jeff')
            ->setLastName('bezos')
            ->setEmail('jeff.bezon@amazon.com')
            ->setPhoneNumber('123456789')
            ->setPhoneCountry('1')
            ->setAddressLine1('amzn')
            ->setAddressLine2('1')
            ->setLocality('LA')
            ->setRegion('CA')
            ->setPostalCode('123')
            ->setCountry('US');

        $data
            ->setMerchantReference($id = uniqid())
            ->setReturnUrl('https://google.com?q=montonio+return+url')
            ->setNotificationUrl('https://google.com?q=montonio+notification')
            ->setGrandTotal(1337)
            ->setCurrency('EUR')
            ->setPayment(
                $payment = (new Payment())
                    ->setCurrency('EUR')
                    ->setAmount(1337)
                    ->setMethod(Payment::METHOD_PAYMENT_INITIATION)
            )
            ->addLineItem(
                $item1 = (new LineItem())
                    ->setName('elephant')
                    ->setFinalPrice(667.5)
                    ->setQuantity(2)
            )
            ->addLineItem(
                $item2 = (new LineItem())
                    ->setName('not elephant')
                    ->setFinalPrice(2)
            )
            ->setExp($exp = time() + 599)
            ->setLocale('en')
            ->setBillingAddress($address)
            ->setShippingAddress($address)
        ;

        $dataRaw = $data->toArray();

        $this->assertSame(1337.0, $data->getGrandTotal());
        $this->assertSame(1337.0, $dataRaw['grandTotal']);

        $this->assertSame($id, $data->getMerchantReference());
        $this->assertSame('https://google.com?q=montonio+return+url', $data->getReturnUrl());
        $this->assertSame('https://google.com?q=montonio+notification', $data->getNotificationUrl());
        $this->assertSame('EUR', $data->getCurrency());
        $this->assertSame($payment, $data->getPayment());
        $this->assertSame($item1, $data->getLineItems()[0]);
        $this->assertSame($item2, $data->getLineItems()[1]);
        $this->assertSame($address, $data->getBillingAddress());
        $this->assertSame($address, $data->getShippingAddress());
        $this->assertSame($exp, $data->getExp());

        $this->assertCount(2, $dataRaw['lineItems']);
        $this->assertIsArray($dataRaw['lineItems'][1]);
        $this->assertSame(2.0, $dataRaw['lineItems'][1]['finalPrice']);
    }
}
