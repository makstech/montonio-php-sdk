<?php

declare(strict_types=1);

namespace Tests\Unit\Clients\Shipping;

use Montonio\Clients\Shipping\ShippingMethodsClient;
use Montonio\Structs\Shipping\FilterByParcelsData;
use Montonio\Structs\Shipping\RatesItem;
use Montonio\Structs\Shipping\RatesParcel;
use Montonio\Structs\Shipping\ShipmentParcel;
use Montonio\Structs\Shipping\ShippingRatesData;
use Tests\BaseTestCase;

class ShippingMethodsClientTest extends BaseTestCase
{
    private function createClientMock(): ShippingMethodsClient
    {
        return $this->getMockBuilder(ShippingMethodsClient::class)
            ->setConstructorArgs([ACCESS_KEY, SECRET_KEY, 'sandbox'])
            ->onlyMethods(['call'])
            ->getMock();
    }

    public function testGetShippingMethods(): void
    {
        $mock = $this->createClientMock();

        $mock->expects($this->once())
            ->method('call')
            ->with(
                'GET',
                $this->stringContains('/shipping-methods'),
            )
            ->willReturn(['countries' => []]);

        $result = $mock->getShippingMethods();

        $this->assertSame(['countries' => []], $result);
    }

    public function testGetPickupPoints(): void
    {
        $mock = $this->createClientMock();

        $mock->expects($this->once())
            ->method('call')
            ->with(
                'GET',
                $this->stringContains('/shipping-methods/pickup-points?carrierCode=omniva&countryCode=EE'),
            )
            ->willReturn(['pickupPoints' => []]);

        $result = $mock->getPickupPoints('omniva', 'EE');

        $this->assertSame(['pickupPoints' => []], $result);
    }

    public function testGetPickupPointsWithType(): void
    {
        $mock = $this->createClientMock();

        $mock->expects($this->once())
            ->method('call')
            ->with(
                'GET',
                $this->stringContains('type=parcelMachine'),
            )
            ->willReturn(['pickupPoints' => []]);

        $mock->getPickupPoints('omniva', 'EE', 'parcelMachine');
    }

    public function testGetCourierServices(): void
    {
        $mock = $this->createClientMock();

        $mock->expects($this->once())
            ->method('call')
            ->with(
                'GET',
                $this->stringContains('/shipping-methods/courier-services?carrierCode=dpd&countryCode=EE'),
            )
            ->willReturn(['courierServices' => []]);

        $result = $mock->getCourierServices('dpd', 'EE');

        $this->assertSame(['courierServices' => []], $result);
    }

    public function testFilterByParcels(): void
    {
        $mock = $this->createClientMock();

        $mock->expects($this->once())
            ->method('call')
            ->with(
                'POST',
                $this->stringContains('/shipping-methods/filter-by-parcels?destination=EE'),
                $this->callback(function ($payload) {
                    $data = json_decode($payload, true);
                    return isset($data['parcels'][0]['weight']);
                }),
            )
            ->willReturn(['countries' => []]);

        $data = (new FilterByParcelsData())
            ->setParcels([(new ShipmentParcel())->setWeight(1.0)]);

        $result = $mock->filterByParcels($data, 'EE');

        $this->assertSame(['countries' => []], $result);
    }

    public function testGetRates(): void
    {
        $mock = $this->createClientMock();

        $mock->expects($this->once())
            ->method('call')
            ->with(
                'POST',
                $this->stringContains('/shipping-methods/rates'),
                $this->callback(function ($payload) {
                    $data = json_decode($payload, true);
                    return $data['destination'] === 'EE';
                }),
            )
            ->willReturn(['carriers' => [], 'destination' => 'EE']);

        $data = (new ShippingRatesData())
            ->setDestination('EE')
            ->setParcels([
                (new RatesParcel())->setItems([
                    (new RatesItem())->setLength(20.0)->setWidth(15.0)->setHeight(10.0)->setWeight(0.5),
                ]),
            ]);

        $result = $mock->getRates($data);

        $this->assertSame('EE', $result['destination']);
    }

    public function testGetRatesWithQueryParams(): void
    {
        $mock = $this->createClientMock();

        $mock->expects($this->once())
            ->method('call')
            ->with(
                'POST',
                $this->logicalAnd(
                    $this->stringContains('carrierCode=omniva'),
                    $this->stringContains('shippingMethodType=pickupPoint')
                ),
            )
            ->willReturn(['carriers' => []]);

        $data = (new ShippingRatesData())
            ->setDestination('EE')
            ->setParcels([
                (new RatesParcel())->setItems([
                    (new RatesItem())->setLength(10.0)->setWidth(5.0)->setHeight(3.0)->setWeight(1.0),
                ]),
            ]);

        $mock->getRates($data, 'omniva', 'pickupPoint');
    }
}
