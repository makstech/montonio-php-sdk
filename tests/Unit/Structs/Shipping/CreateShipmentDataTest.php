<?php

declare(strict_types=1);

namespace Tests\Unit\Structs\Shipping;

use Montonio\Structs\Shipping\CreateShipmentData;
use Montonio\Structs\Shipping\ShipmentParcel;
use Montonio\Structs\Shipping\ShipmentProduct;
use Montonio\Structs\Shipping\ShipmentShippingMethod;
use Montonio\Structs\Shipping\ShippingContact;
use Tests\BaseTestCase;

class CreateShipmentDataTest extends BaseTestCase
{
    public function testFluentSetters(): void
    {
        $data = (new CreateShipmentData())
            ->setShippingMethod(
                (new ShipmentShippingMethod())
                    ->setType('pickupPoint')
                    ->setId('abc-123')
            )
            ->setReceiver(
                (new ShippingContact())
                    ->setName('Receiver X')
                    ->setPhoneCountryCode('372')
                    ->setPhoneNumber('53334770')
            )
            ->setSender(
                (new ShippingContact())
                    ->setName('Sender Y')
                    ->setPhoneCountryCode('370')
                    ->setPhoneNumber('12345678')
            )
            ->setParcels([
                (new ShipmentParcel())->setWeight(1.0),
            ])
            ->setProducts([
                (new ShipmentProduct())->setSku('sku-1')->setName('Widget')->setQuantity(2),
            ])
            ->setMerchantReference('order-1')
            ->setMontonioOrderUuid('montonio-uuid-123')
            ->setOrderComment('Please handle with care')
            ->setSynchronous(true);

        $this->assertSame('pickupPoint', $data->getShippingMethod()->getType());
        $this->assertSame('Receiver X', $data->getReceiver()->getName());
        $this->assertSame('Sender Y', $data->getSender()->getName());
        $this->assertCount(1, $data->getParcels());
        $this->assertCount(1, $data->getProducts());
        $this->assertSame('sku-1', $data->getProducts()[0]->getSku());
        $this->assertSame('order-1', $data->getMerchantReference());
        $this->assertSame('montonio-uuid-123', $data->getMontonioOrderUuid());
        $this->assertSame('Please handle with care', $data->getOrderComment());
        $this->assertTrue($data->getSynchronous());
    }

    public function testConstructFromArray(): void
    {
        $data = new CreateShipmentData([
            'shippingMethod' => [
                'type' => 'courier',
                'id' => 'def-456',
            ],
            'receiver' => [
                'name' => 'Test',
                'phoneCountryCode' => '372',
                'phoneNumber' => '555',
            ],
            'parcels' => [
                ['weight' => 2.0],
            ],
            'products' => [
                ['sku' => 'sku-1', 'name' => 'Widget', 'quantity' => 1],
            ],
        ]);

        $this->assertInstanceOf(ShipmentShippingMethod::class, $data->getShippingMethod());
        $this->assertSame('courier', $data->getShippingMethod()->getType());
        $this->assertInstanceOf(ShippingContact::class, $data->getReceiver());
        $this->assertInstanceOf(ShipmentParcel::class, $data->getParcels()[0]);
        $this->assertInstanceOf(ShipmentProduct::class, $data->getProducts()[0]);
        $this->assertSame('sku-1', $data->getProducts()[0]->getSku());
    }

    public function testToArray(): void
    {
        $data = (new CreateShipmentData())
            ->setShippingMethod(
                (new ShipmentShippingMethod())
                    ->setType('pickupPoint')
                    ->setId('abc-123')
            )
            ->setReceiver(
                (new ShippingContact())
                    ->setName('Test')
                    ->setPhoneCountryCode('372')
                    ->setPhoneNumber('555')
            )
            ->setParcels([
                (new ShipmentParcel())->setWeight(1.5),
            ]);

        $array = $data->toArray();

        $this->assertSame('pickupPoint', $array['shippingMethod']['type']);
        $this->assertSame('Test', $array['receiver']['name']);
        $this->assertSame(1.5, $array['parcels'][0]['weight']);
    }

    public function testNullableGetters(): void
    {
        $data = new CreateShipmentData();

        $this->assertNull($data->getShippingMethod());
        $this->assertNull($data->getReceiver());
        $this->assertNull($data->getSender());
        $this->assertNull($data->getMerchantReference());
        $this->assertNull($data->getMontonioOrderUuid());
        $this->assertNull($data->getOrderComment());
        $this->assertNull($data->getSynchronous());
    }
}
