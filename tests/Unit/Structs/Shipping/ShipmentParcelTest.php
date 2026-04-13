<?php

declare(strict_types=1);

namespace Tests\Unit\Structs\Shipping;

use Montonio\Structs\Shipping\ShipmentParcel;
use Tests\BaseTestCase;

class ShipmentParcelTest extends BaseTestCase
{
    public function testFluentSettersAndGetters(): void
    {
        $parcel = (new ShipmentParcel())
            ->setWeight(2.5)
            ->setHeight(0.64)
            ->setWidth(0.38)
            ->setLength(0.39);

        $this->assertSame(2.5, $parcel->getWeight());
        $this->assertSame(0.64, $parcel->getHeight());
        $this->assertSame(0.38, $parcel->getWidth());
        $this->assertSame(0.39, $parcel->getLength());
    }

    public function testToArray(): void
    {
        $parcel = (new ShipmentParcel())
            ->setWeight(1.0)
            ->setLength(0.5);

        $array = $parcel->toArray();

        $this->assertSame(1.0, $array['weight']);
        $this->assertSame(0.5, $array['length']);
    }

    public function testConstructFromArray(): void
    {
        $parcel = new ShipmentParcel([
            'weight' => 3.0,
            'height' => 0.2,
        ]);

        $this->assertSame(3.0, $parcel->getWeight());
        $this->assertSame(0.2, $parcel->getHeight());
    }

    public function testNullableGetters(): void
    {
        $parcel = new ShipmentParcel();

        $this->assertNull($parcel->getWeight());
        $this->assertNull($parcel->getHeight());
        $this->assertNull($parcel->getWidth());
        $this->assertNull($parcel->getLength());
    }
}
