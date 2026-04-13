<?php

declare(strict_types=1);

namespace Tests\Unit\Structs\Shipping;

use Montonio\Structs\Shipping\FilterByParcelsData;
use Montonio\Structs\Shipping\ShipmentParcel;
use Tests\BaseTestCase;

class FilterByParcelsDataTest extends BaseTestCase
{
    public function testFromArray(): void
    {
        $data = new FilterByParcelsData([
            'parcels' => [
                ['weight' => 1.5],
            ],
        ]);

        $this->assertCount(1, $data->getParcels());
        $this->assertInstanceOf(ShipmentParcel::class, $data->getParcels()[0]);
        $this->assertSame(1.5, $data->getParcels()[0]->getWeight());
    }

    public function testToArray(): void
    {
        $data = (new FilterByParcelsData())
            ->setParcels([
                (new ShipmentParcel())->setWeight(2.0)->setHeight(0.5),
            ]);

        $array = $data->toArray();

        $this->assertSame(2.0, $array['parcels'][0]['weight']);
        $this->assertSame(0.5, $array['parcels'][0]['height']);
    }
}
