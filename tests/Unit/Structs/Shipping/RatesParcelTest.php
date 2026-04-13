<?php

declare(strict_types=1);

namespace Tests\Unit\Structs\Shipping;

use Montonio\Structs\Shipping\RatesItem;
use Montonio\Structs\Shipping\RatesParcel;
use Tests\BaseTestCase;

class RatesParcelTest extends BaseTestCase
{
    public function testSetItemsFromArray(): void
    {
        $parcel = new RatesParcel([
            'items' => [
                ['length' => 20.0, 'width' => 15.0, 'height' => 10.0, 'weight' => 0.5],
            ],
        ]);

        $items = $parcel->getItems();
        $this->assertCount(1, $items);
        $this->assertInstanceOf(RatesItem::class, $items[0]);
        $this->assertSame(20.0, $items[0]->getLength());
    }

    public function testToArray(): void
    {
        $parcel = (new RatesParcel())
            ->setItems([
                (new RatesItem())->setLength(10.0)->setWidth(5.0)->setHeight(3.0)->setWeight(1.0),
            ]);

        $array = $parcel->toArray();

        $this->assertSame(10.0, $array['items'][0]['length']);
        $this->assertSame(1.0, $array['items'][0]['weight']);
    }
}
