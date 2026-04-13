<?php

declare(strict_types=1);

namespace Tests\Unit\Structs\Shipping;

use Montonio\Structs\Shipping\CreateLabelFileData;
use Tests\BaseTestCase;

class CreateLabelFileDataTest extends BaseTestCase
{
    public function testFluentSetters(): void
    {
        $data = (new CreateLabelFileData())
            ->setShipmentIds(['uuid-1', 'uuid-2'])
            ->setPageSize('A4')
            ->setLabelsPerPage(4)
            ->setOrderLabelsBy('carrier')
            ->setSynchronous(true);

        $this->assertSame(['uuid-1', 'uuid-2'], $data->getShipmentIds());
        $this->assertSame('A4', $data->getPageSize());
        $this->assertSame(4, $data->getLabelsPerPage());
        $this->assertSame('carrier', $data->getOrderLabelsBy());
        $this->assertTrue($data->getSynchronous());
    }

    public function testToArray(): void
    {
        $data = (new CreateLabelFileData())
            ->setShipmentIds(['uuid-1'])
            ->setPageSize('A6');

        $array = $data->toArray();

        $this->assertSame(['uuid-1'], $array['shipmentIds']);
        $this->assertSame('A6', $array['pageSize']);
    }

    public function testNullableGetters(): void
    {
        $data = new CreateLabelFileData();

        $this->assertNull($data->getPageSize());
        $this->assertNull($data->getLabelsPerPage());
        $this->assertNull($data->getOrderLabelsBy());
        $this->assertNull($data->getSynchronous());
    }
}
