<?php

declare(strict_types=1);

namespace Tests\Unit\Structs\Shipping;

use Montonio\Structs\Shipping\AdditionalService;
use Montonio\Structs\Shipping\ShipmentShippingMethod;
use Tests\BaseTestCase;

class ShipmentShippingMethodTest extends BaseTestCase
{
    public function testFluentSetters(): void
    {
        $method = (new ShipmentShippingMethod())
            ->setType('courier')
            ->setId('aeada198-fab7-4042-a414-82dcf3ea81e8')
            ->setParcelHandoverMethod('courierPickUp')
            ->setLockerSize('M');

        $this->assertSame('courier', $method->getType());
        $this->assertSame('aeada198-fab7-4042-a414-82dcf3ea81e8', $method->getId());
        $this->assertSame('courierPickUp', $method->getParcelHandoverMethod());
        $this->assertSame('M', $method->getLockerSize());
    }

    public function testAdditionalServicesFromArray(): void
    {
        $method = new ShipmentShippingMethod([
            'type' => 'pickupPoint',
            'id' => 'abc-123',
            'additionalServices' => [
                ['code' => 'cod', 'params' => ['amount' => 25.50]],
                ['code' => 'ageVerification'],
            ],
        ]);

        $services = $method->getAdditionalServices();
        $this->assertCount(2, $services);
        $this->assertInstanceOf(AdditionalService::class, $services[0]);
        $this->assertSame('cod', $services[0]->getCode());
        $this->assertSame(25.50, $services[0]->getParams()->getAmount());
        $this->assertSame('ageVerification', $services[1]->getCode());
    }

    public function testToArray(): void
    {
        $method = (new ShipmentShippingMethod())
            ->setType('courier')
            ->setId('abc-123')
            ->setAdditionalServices([
                (new AdditionalService())->setCode('cod'),
            ]);

        $array = $method->toArray();

        $this->assertSame('courier', $array['type']);
        $this->assertSame('abc-123', $array['id']);
        $this->assertSame('cod', $array['additionalServices'][0]['code']);
    }

    public function testNullableGetters(): void
    {
        $method = new ShipmentShippingMethod();

        $this->assertNull($method->getType());
        $this->assertNull($method->getId());
        $this->assertNull($method->getParcelHandoverMethod());
        $this->assertNull($method->getLockerSize());
    }
}
