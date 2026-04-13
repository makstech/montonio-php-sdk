<?php

declare(strict_types=1);

namespace Tests\Unit\Structs\Shipping;

use Montonio\Structs\Shipping\RatesItem;
use Montonio\Structs\Shipping\RatesParcel;
use Montonio\Structs\Shipping\ShippingRatesData;
use Tests\BaseTestCase;

class ShippingRatesDataTest extends BaseTestCase
{
    public function testFluentSetters(): void
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

        $this->assertSame('EE', $data->getDestination());
        $this->assertCount(1, $data->getParcels());
        $this->assertSame(20.0, $data->getParcels()[0]->getItems()[0]->getLength());
    }

    public function testToArray(): void
    {
        $data = (new ShippingRatesData())
            ->setDestination('LT')
            ->setParcels([
                (new RatesParcel())->setItems([
                    (new RatesItem())
                        ->setLength(10.0)
                        ->setWidth(5.0)
                        ->setHeight(3.0)
                        ->setWeight(1.0)
                        ->setDimensionUnit('cm')
                        ->setWeightUnit('kg'),
                ]),
            ]);

        $array = $data->toArray();

        $this->assertSame('LT', $array['destination']);
        $this->assertSame('cm', $array['parcels'][0]['items'][0]['dimensionUnit']);
    }

    public function testNullableGetters(): void
    {
        $data = new ShippingRatesData();

        $this->assertNull($data->getDestination());
    }
}
