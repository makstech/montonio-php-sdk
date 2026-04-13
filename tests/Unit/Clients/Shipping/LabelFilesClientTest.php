<?php

declare(strict_types=1);

namespace Tests\Unit\Clients\Shipping;

use Montonio\Clients\Shipping\LabelFilesClient;
use Montonio\Structs\Shipping\CreateLabelFileData;
use Tests\BaseTestCase;

class LabelFilesClientTest extends BaseTestCase
{
    private function createClientMock(): LabelFilesClient
    {
        return $this->getMockBuilder(LabelFilesClient::class)
            ->setConstructorArgs([ACCESS_KEY, SECRET_KEY, 'sandbox'])
            ->onlyMethods(['call'])
            ->getMock();
    }

    public function testCreateLabelFile(): void
    {
        $mock = $this->createClientMock();

        $mock->expects($this->once())
            ->method('call')
            ->with(
                'POST',
                $this->stringContains('/label-files'),
                $this->callback(function ($payload) {
                    $data = json_decode($payload, true);
                    return $data['shipmentIds'] === ['uuid-1']
                        && $data['pageSize'] === 'A4';
                }),
            )
            ->willReturn(['id' => 'label-uuid', 'status' => 'pending']);

        $data = (new CreateLabelFileData())
            ->setShipmentIds(['uuid-1'])
            ->setPageSize('A4')
            ->setSynchronous(true);

        $result = $mock->createLabelFile($data);

        $this->assertSame('label-uuid', $result['id']);
    }

    public function testGetLabelFile(): void
    {
        $mock = $this->createClientMock();

        $mock->expects($this->once())
            ->method('call')
            ->with(
                'GET',
                $this->stringContains('/label-files/label-uuid'),
            )
            ->willReturn(['id' => 'label-uuid', 'status' => 'ready', 'labelFileUrl' => 'https://example.com/label.pdf']);

        $result = $mock->getLabelFile('label-uuid');

        $this->assertSame('ready', $result['status']);
    }
}
