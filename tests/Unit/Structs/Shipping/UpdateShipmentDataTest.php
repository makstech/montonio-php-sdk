<?php

declare(strict_types=1);

namespace Tests\Unit\Structs\Shipping;

use Montonio\Structs\Shipping\ShipmentParcel;
use Montonio\Structs\Shipping\ShipmentShippingMethod;
use Montonio\Structs\Shipping\ShippingContact;
use Montonio\Structs\Shipping\UpdateShipmentData;
use Tests\BaseTestCase;

class UpdateShipmentDataTest extends BaseTestCase
{
    public function testFluentSetters(): void
    {
        $data = (new UpdateShipmentData())
            ->setShippingMethod(
                (new ShipmentShippingMethod())->setType('courier')->setId('abc-123')
            )
            ->setReceiver(
                (new ShippingContact())->setName('Receiver')->setPhoneCountryCode('372')->setPhoneNumber('555')
            )
            ->setSender(
                (new ShippingContact())->setName('Sender')->setPhoneCountryCode('370')->setPhoneNumber('666')
            )
            ->setParcels([
                (new ShipmentParcel())->setWeight(2.0),
            ]);

        $this->assertSame('courier', $data->getShippingMethod()->getType());
        $this->assertSame('Receiver', $data->getReceiver()->getName());
        $this->assertSame('Sender', $data->getSender()->getName());
        $this->assertCount(1, $data->getParcels());
        $this->assertSame(2.0, $data->getParcels()[0]->getWeight());
    }

    public function testConstructFromArray(): void
    {
        $data = new UpdateShipmentData([
            'shippingMethod' => [
                'type' => 'pickupPoint',
                'id' => 'pp-456',
            ],
            'receiver' => [
                'name' => 'Test',
                'phoneCountryCode' => '372',
                'phoneNumber' => '555',
            ],
            'parcels' => [
                ['weight' => 1.5],
            ],
        ]);

        $this->assertInstanceOf(ShipmentShippingMethod::class, $data->getShippingMethod());
        $this->assertSame('pickupPoint', $data->getShippingMethod()->getType());
        $this->assertInstanceOf(ShippingContact::class, $data->getReceiver());
        $this->assertInstanceOf(ShipmentParcel::class, $data->getParcels()[0]);
    }

    public function testToArray(): void
    {
        $data = (new UpdateShipmentData())
            ->setReceiver(
                (new ShippingContact())->setName('Updated')->setPhoneCountryCode('372')->setPhoneNumber('555')
            )
            ->setParcels([
                (new ShipmentParcel())->setWeight(3.0),
            ]);

        $array = $data->toArray();

        $this->assertSame('Updated', $array['receiver']['name']);
        $this->assertSame(3.0, $array['parcels'][0]['weight']);
    }

    public function testNullableGetters(): void
    {
        $data = new UpdateShipmentData();

        $this->assertNull($data->getShippingMethod());
        $this->assertNull($data->getReceiver());
        $this->assertNull($data->getSender());
    }
}
