<?php

declare(strict_types=1);

namespace Tests\Integration\Clients;

use Tests\Integration\IntegrationTestCase;

class PayoutsClientTest extends IntegrationTestCase
{
    public function testGetBalances(): void
    {
        $response = $this->getMontonioClient()->payouts()->getBalances();

        $this->assertArrayHasKey('store', $response);
        $this->assertArrayHasKey('balances', $response);
    }

    public function testGetPayouts(): void
    {
        $balances = $this->getMontonioClient()->payouts()->getBalances();
        $storeUuid = $balances['store']['uuid'];

        $response = $this->getMontonioClient()->payouts()->getPayouts($storeUuid, limit: 10);

        $this->assertArrayHasKey('payouts', $response);
        $this->assertIsArray($response['payouts']);
    }

    public function testGetPayoutsWithOrderBy(): void
    {
        $balances = $this->getMontonioClient()->payouts()->getBalances();
        $storeUuid = $balances['store']['uuid'];

        $response = $this->getMontonioClient()->payouts()->getPayouts($storeUuid, limit: 10, orderBy: 'createdAt');

        $this->assertArrayHasKey('payouts', $response);
    }

    public function testExportPayout(): void
    {
        $balances = $this->getMontonioClient()->payouts()->getBalances();
        $storeUuid = $balances['store']['uuid'];

        $payouts = $this->getMontonioClient()->payouts()->getPayouts($storeUuid, limit: 1);

        if (empty($payouts['payouts'])) {
            $this->markTestSkipped('No payouts available in sandbox to test export.');
        }

        $payoutUuid = $payouts['payouts'][0]['uuid'];
        $response = $this->getMontonioClient()->payouts()->exportPayout($storeUuid, $payoutUuid);

        $this->assertArrayHasKey('url', $response);
    }
}
