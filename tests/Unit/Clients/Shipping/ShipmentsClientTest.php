<?php

declare(strict_types=1);

namespace Tests\Unit\Clients\Shipping;

use Montonio\Clients\Shipping\ShipmentsClient;
use Montonio\Structs\Shipping\CreateShipmentData;
use Montonio\Structs\Shipping\ShipmentParcel;
use Montonio\Structs\Shipping\ShipmentShippingMethod;
use Montonio\Structs\Shipping\ShippingContact;
use Montonio\Structs\Shipping\UpdateShipmentData;
use Tests\BaseTestCase;

class ShipmentsClientTest extends BaseTestCase
{
    private function createClientMock(): ShipmentsClient
    {
        return $this->getMockBuilder(ShipmentsClient::class)
            ->setConstructorArgs([ACCESS_KEY, SECRET_KEY, 'sandbox'])
            ->onlyMethods(['call'])
            ->getMock();
    }

    public function testCreateShipment(): void
    {
        $mock = $this->createClientMock();

        $mock->expects($this->once())
            ->method('call')
            ->with(
                'POST',
                $this->stringContains('/shipments'),
                $this->callback(function ($payload) {
                    $data = json_decode($payload, true);
                    return $data['shippingMethod']['type'] === 'pickupPoint'
                        && $data['receiver']['name'] === 'Test';
                }),
            )
            ->willReturn(['id' => 'shipment-uuid', 'status' => 'pending']);

        $data = (new CreateShipmentData())
            ->setShippingMethod(
                (new ShipmentShippingMethod())->setType('pickupPoint')->setId('pp-123')
            )
            ->setReceiver(
                (new ShippingContact())->setName('Test')->setPhoneCountryCode('372')->setPhoneNumber('555')
            )
            ->setParcels([(new ShipmentParcel())->setWeight(1.0)]);

        $result = $mock->createShipment($data);

        $this->assertSame('shipment-uuid', $result['id']);
        $this->assertSame('pending', $result['status']);
    }

    public function testUpdateShipment(): void
    {
        $mock = $this->createClientMock();

        $mock->expects($this->once())
            ->method('call')
            ->with(
                'PATCH',
                $this->stringContains('/shipments/shipment-uuid'),
                $this->callback(function ($payload) {
                    $data = json_decode($payload, true);
                    return $data['receiver']['name'] === 'Updated';
                }),
            )
            ->willReturn(['id' => 'shipment-uuid']);

        $data = (new UpdateShipmentData())
            ->setReceiver(
                (new ShippingContact())->setName('Updated')->setPhoneCountryCode('372')->setPhoneNumber('555')
            );

        $result = $mock->updateShipment('shipment-uuid', $data);

        $this->assertSame('shipment-uuid', $result['id']);
    }

    public function testGetShipment(): void
    {
        $mock = $this->createClientMock();

        $mock->expects($this->once())
            ->method('call')
            ->with(
                'GET',
                $this->stringContains('/shipments/shipment-uuid'),
            )
            ->willReturn(['id' => 'shipment-uuid', 'status' => 'registered']);

        $result = $mock->getShipment('shipment-uuid');

        $this->assertSame('shipment-uuid', $result['id']);
    }
}
