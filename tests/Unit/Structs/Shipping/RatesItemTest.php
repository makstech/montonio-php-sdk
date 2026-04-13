<?php

declare(strict_types=1);

namespace Tests\Unit\Structs\Shipping;

use Montonio\Structs\Shipping\RatesItem;
use Tests\BaseTestCase;

class RatesItemTest extends BaseTestCase
{
    public function testFluentSetters(): void
    {
        $item = (new RatesItem())
            ->setLength(20.0)
            ->setWidth(15.0)
            ->setHeight(10.0)
            ->setWeight(0.5)
            ->setDimensionUnit('cm')
            ->setWeightUnit('kg')
            ->setQuantity(2);

        $this->assertSame(20.0, $item->getLength());
        $this->assertSame(15.0, $item->getWidth());
        $this->assertSame(10.0, $item->getHeight());
        $this->assertSame(0.5, $item->getWeight());
        $this->assertSame('cm', $item->getDimensionUnit());
        $this->assertSame('kg', $item->getWeightUnit());
        $this->assertSame(2, $item->getQuantity());
    }

    public function testToArray(): void
    {
        $item = (new RatesItem())
            ->setLength(20.0)
            ->setWidth(15.0)
            ->setHeight(10.0)
            ->setWeight(0.5);

        $array = $item->toArray();

        $this->assertSame(20.0, $array['length']);
        $this->assertSame(0.5, $array['weight']);
    }

    public function testNullableGetters(): void
    {
        $item = new RatesItem();

        $this->assertNull($item->getLength());
        $this->assertNull($item->getDimensionUnit());
        $this->assertNull($item->getQuantity());
    }
}
