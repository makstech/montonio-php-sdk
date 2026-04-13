<?php

declare(strict_types=1);

namespace Tests\Integration\Clients\Shipping;

use Montonio\Exception\ApiException;
use Montonio\Structs\Shipping\FilterByParcelsData;
use Montonio\Structs\Shipping\RatesItem;
use Montonio\Structs\Shipping\RatesParcel;
use Montonio\Structs\Shipping\ShipmentParcel;
use Montonio\Structs\Shipping\ShippingRatesData;
use Tests\Integration\IntegrationTestCase;

class ShippingMethodsClientTest extends IntegrationTestCase
{
    private function getShippingMethodsOrSkip(): array
    {
        try {
            return $this->getMontonioClient()->shipping()->shippingMethods()->getShippingMethods();
        } catch (ApiException $e) {
            $this->markTestSkipped('Shipping methods not available in sandbox: ' . $e->getMessage());
        }
    }

    public function testGetShippingMethods(): void
    {
        $response = $this->getShippingMethodsOrSkip();

        $this->assertArrayHasKey('countries', $response);
        $this->assertIsArray($response['countries']);
    }

    public function testGetPickupPoints(): void
    {
        $methods = $this->getShippingMethodsOrSkip();

        $carrierCode = null;
        $countryCode = null;

        foreach ($methods['countries'] as $country) {
            foreach ($country['carriers'] as $carrier) {
                foreach ($carrier['shippingMethods'] as $method) {
                    if ($method['type'] === 'pickupPoint') {
                        $carrierCode = $carrier['carrierCode'];
                        $countryCode = $country['countryCode'];
                        break 3;
                    }
                }
            }
        }

        if ($carrierCode === null) {
            $this->markTestSkipped('No pickup point carriers available in sandbox.');
        }

        $response = $this->getMontonioClient()->shipping()->shippingMethods()
            ->getPickupPoints($carrierCode, $countryCode);

        $this->assertArrayHasKey('pickupPoints', $response);
        $this->assertIsArray($response['pickupPoints']);
    }

    public function testGetCourierServices(): void
    {
        $methods = $this->getShippingMethodsOrSkip();

        $carrierCode = null;
        $countryCode = null;

        foreach ($methods['countries'] as $country) {
            foreach ($country['carriers'] as $carrier) {
                foreach ($carrier['shippingMethods'] as $method) {
                    if ($method['type'] === 'courier') {
                        $carrierCode = $carrier['carrierCode'];
                        $countryCode = $country['countryCode'];
                        break 3;
                    }
                }
            }
        }

        if ($carrierCode === null) {
            $this->markTestSkipped('No courier carriers available in sandbox.');
        }

        $response = $this->getMontonioClient()->shipping()->shippingMethods()
            ->getCourierServices($carrierCode, $countryCode);

        $this->assertArrayHasKey('courierServices', $response);
        $this->assertIsArray($response['courierServices']);
    }

    public function testFilterByParcels(): void
    {
        $data = (new FilterByParcelsData())
            ->setParcels([
                (new ShipmentParcel())->setWeight(1.0),
            ]);

        $response = $this->getMontonioClient()->shipping()->shippingMethods()
            ->filterByParcels($data, 'EE');

        $this->assertArrayHasKey('countries', $response);
    }

    public function testGetRates(): void
    {
        $data = (new ShippingRatesData())
            ->setDestination('EE')
            ->setParcels([
                (new RatesParcel())->setItems([
                    (new RatesItem())
                        ->setLength(20.0)
                        ->setWidth(15.0)
                        ->setHeight(10.0)
                        ->setWeight(0.5),
                ]),
            ]);

        $response = $this->getMontonioClient()->shipping()->shippingMethods()
            ->getRates($data);

        $this->assertArrayHasKey('carriers', $response);
        $this->assertArrayHasKey('destination', $response);
    }
}
