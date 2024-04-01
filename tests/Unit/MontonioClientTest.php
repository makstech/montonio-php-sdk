<?php

declare(strict_types=1);

namespace Tests\Unit;

use Montonio\Clients\OrdersClient;
use Montonio\Clients\StoresClient;
use Montonio\Structs\OrderData;
use stdClass;
use Tests\BaseTestCase;

class MontonioClientTest extends BaseTestCase
{
    public function testJwt(): void
    {
        $data = new OrderData();
        $data->setLocale('lv');

        $client = $this->getMontonioClient();
        $token = $client->generateToken($data->toArray());
        $decoded = $client->decodeToken($token);

        $this->assertNotEmpty($token);
        $this->assertInstanceOf(stdClass::class, $decoded);
        $this->assertSame('lv', $decoded->locale);
    }

    public function testGetOrdersClient(): void
    {
        $data = new OrderData();
        $data->setLocale('lv');

        $client = $this->getMontonioClient()->orders();

        $this->assertInstanceOf(OrdersClient::class, $client);

        $token = $client->generateToken($data->toArray());
        $decoded = $client->decodeToken($token);

        $this->assertSame(ACCESS_KEY, $decoded->accessKey, 'Access Key was not passed from parent client');
    }

    public function testGetStoresClient(): void
    {
        $client = $this->getMontonioClient()->stores();

        $this->assertInstanceOf(StoresClient::class, $client);
    }
}
