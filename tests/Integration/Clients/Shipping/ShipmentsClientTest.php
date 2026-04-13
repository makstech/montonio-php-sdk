<?php

declare(strict_types=1);

namespace Tests\Integration\Clients\Shipping;

use Montonio\Exception\ApiException;
use Montonio\Structs\Shipping\CreateShipmentData;
use Montonio\Structs\Shipping\ShipmentParcel;
use Montonio\Structs\Shipping\ShipmentShippingMethod;
use Montonio\Structs\Shipping\ShippingContact;
use Montonio\Structs\Shipping\UpdateShipmentData;
use Tests\Integration\IntegrationTestCase;

class ShipmentsClientTest extends IntegrationTestCase
{
    private function findPickupPointIdOrSkip(): string
    {
        $client = $this->getMontonioClient()->shipping();

        try {
            $methods = $client->shippingMethods()->getShippingMethods();
        } catch (ApiException $e) {
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

        return $pickupPoints['pickupPoints'][0]['id'];
    }

    public function testCreateGetAndUpdateShipment(): void
    {
        $pickupPointId = $this->findPickupPointIdOrSkip();
        $client = $this->getMontonioClient()->shipping();

        // Create shipment
        $data = (new CreateShipmentData())
            ->setShippingMethod(
                (new ShipmentShippingMethod())
                    ->setType('pickupPoint')
                    ->setId($pickupPointId)
            )
            ->setReceiver(
                (new ShippingContact())
                    ->setName('Test Receiver')
                    ->setPhoneCountryCode('372')
                    ->setPhoneNumber('53334770')
                    ->setEmail('test@example.com')
            )
            ->setParcels([
                (new ShipmentParcel())->setWeight(1.0),
            ])
            ->setMerchantReference('sdk-test-' . time());

        $created = $client->shipments()->createShipment($data);

        $this->assertArrayHasKey('id', $created);
        $this->assertArrayHasKey('status', $created);

        // Get shipment
        $fetched = $client->shipments()->getShipment($created['id']);

        $this->assertSame($created['id'], $fetched['id']);

        // Update shipment
        $updateData = (new UpdateShipmentData())
            ->setReceiver(
                (new ShippingContact())
                    ->setName('Updated Receiver')
                    ->setPhoneCountryCode('372')
                    ->setPhoneNumber('53334770')
            );

        $updated = $client->shipments()->updateShipment($created['id'], $updateData);

        $this->assertSame($created['id'], $updated['id']);
    }
}
