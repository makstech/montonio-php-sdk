<?php

declare(strict_types=1);

namespace Tests\Integration\Clients\Shipping;

use Montonio\Exception\RequestException;
use Montonio\Structs\Shipping\CreateLabelFileData;
use Montonio\Structs\Shipping\CreateShipmentData;
use Montonio\Structs\Shipping\ShipmentParcel;
use Montonio\Structs\Shipping\ShipmentShippingMethod;
use Montonio\Structs\Shipping\ShippingContact;
use Tests\Integration\IntegrationTestCase;

class LabelFilesClientTest extends IntegrationTestCase
{
    public function testCreateAndGetLabelFile(): void
    {
        $client = $this->getMontonioClient()->shipping();

        // Get a pickup point ID
        try {
            $methods = $client->shippingMethods()->getShippingMethods();
        } catch (RequestException $e) {
            $this->markTestSkipped('Shipping methods not available in sandbox: ' . $e->getMessage());
        }

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

        $pickupPoints = $client->shippingMethods()->getPickupPoints($carrierCode, $countryCode);

        if (empty($pickupPoints['pickupPoints'])) {
            $this->markTestSkipped('No pickup points available in sandbox.');
        }

        $pickupPointId = $pickupPoints['pickupPoints'][0]['id'];

        // Create a shipment first
        $shipment = $client->shipments()->createShipment(
            (new CreateShipmentData())
                ->setShippingMethod(
                    (new ShipmentShippingMethod())
                        ->setType('pickupPoint')
                        ->setId($pickupPointId)
                )
                ->setReceiver(
                    (new ShippingContact())
                        ->setName('Label Test')
                        ->setPhoneCountryCode('372')
                        ->setPhoneNumber('53334770')
                )
                ->setParcels([
                    (new ShipmentParcel())->setWeight(1.0),
                ])
                ->setMerchantReference('sdk-label-test-' . time())
                ->setSynchronous(true)
        );

        // Create label file
        $labelFile = $client->labels()->createLabelFile(
            (new CreateLabelFileData())
                ->setShipmentIds([$shipment['id']])
                ->setPageSize('A4')
                ->setSynchronous(true)
        );

        $this->assertArrayHasKey('id', $labelFile);
        $this->assertArrayHasKey('status', $labelFile);

        // Get label file
        $fetched = $client->labels()->getLabelFile($labelFile['id']);

        $this->assertSame($labelFile['id'], $fetched['id']);
    }
}
