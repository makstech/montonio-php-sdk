<?php

declare(strict_types=1);

namespace Tests\Unit\Clients;

use Montonio\Clients\PayoutsClient;
use Tests\BaseTestCase;

class PayoutsClientTest extends BaseTestCase
{
    public function testExportPayout(): void
    {
        $mock = $this->getMockBuilder(PayoutsClient::class)
            ->setConstructorArgs([ACCESS_KEY, SECRET_KEY, 'sandbox'])
            ->onlyMethods(['call'])
            ->getMock();

        $mock->expects($this->once())
            ->method('call')
            ->with(
                'GET',
                $this->stringContains('/stores/store-uuid/payouts/payout-uuid/export-excel'),
            )
            ->willReturn(['url' => 'https://example.com/download.xlsx']);

        $result = $mock->exportPayout('store-uuid', 'payout-uuid', 'excel');

        $this->assertSame('https://example.com/download.xlsx', $result['url']);
    }

    public function testExportPayoutXml(): void
    {
        $mock = $this->getMockBuilder(PayoutsClient::class)
            ->setConstructorArgs([ACCESS_KEY, SECRET_KEY, 'sandbox'])
            ->onlyMethods(['call'])
            ->getMock();

        $mock->expects($this->once())
            ->method('call')
            ->with(
                'GET',
                $this->stringContains('/export-xml'),
            )
            ->willReturn(['url' => 'https://example.com/download.xml']);

        $result = $mock->exportPayout('store-uuid', 'payout-uuid', 'xml');

        $this->assertSame('https://example.com/download.xml', $result['url']);
    }
}
