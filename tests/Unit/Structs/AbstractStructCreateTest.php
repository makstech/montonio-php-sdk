<?php

declare(strict_types=1);

namespace Tests\Unit\Structs;

use Montonio\Enums\PaymentMethod;
use Montonio\Structs\CreateRefundData;
use Montonio\Structs\Payment;
use Montonio\Structs\Shipping\CreateShipmentData;
use Montonio\Structs\Shipping\ShipmentParcel;
use Montonio\Structs\Shipping\ShipmentShippingMethod;
use Montonio\Structs\Shipping\ShippingContact;
use Tests\BaseTestCase;

class AbstractStructCreateTest extends BaseTestCase
{
    public function testCreateWithNamedArgs(): void
    {
        $refund = CreateRefundData::create(
            orderUuid: '12228dce-2f7c-4db5-8d28-5d82a19aa3b6',
            amount: 25.00,
            idempotencyKey: 'key-123',
        );

        $this->assertInstanceOf(CreateRefundData::class, $refund);
        $this->assertSame('12228dce-2f7c-4db5-8d28-5d82a19aa3b6', $refund->getOrderUuid());
        $this->assertSame(25.00, $refund->getAmount());
        $this->assertSame('key-123', $refund->getIdempotencyKey());
    }

    public function testCreateProducesCorrectToArray(): void
    {
        $refund = CreateRefundData::create(
            orderUuid: 'uuid-1',
            amount: 10.00,
        );

        $array = $refund->toArray();

        $this->assertSame('uuid-1', $array['orderUuid']);
        $this->assertSame(10.00, $array['amount']);
    }

    public function testCreateWithNestedStructs(): void
    {
        $data = CreateShipmentData::create(
            shippingMethod: ShipmentShippingMethod::create(
                type: 'pickupPoint',
                id: 'pp-123',
            ),
            receiver: ShippingContact::create(
                name: 'John',
                phoneCountryCode: '372',
                phoneNumber: '555',
            ),
            parcels: [ShipmentParcel::create(weight: 1.0)],
        );

        $this->assertSame('pickupPoint', $data->getShippingMethod()->getType());
        $this->assertSame('John', $data->getReceiver()->getName());
    }

    public function testCreateWithEnum(): void
    {
        $payment = Payment::create(
            method: PaymentMethod::Blik,
            amount: 100.00,
            currency: 'PLN',
        );

        $this->assertSame('blik', $payment->getMethod());
        $this->assertSame(100.00, $payment->getAmount());
    }

    public function testCreateIgnoresUnknownFields(): void
    {
        $refund = CreateRefundData::create(
            orderUuid: 'uuid-1',
            nonExistentField: 'ignored',
        );

        $this->assertSame('uuid-1', $refund->getOrderUuid());
    }
}
