<?php

declare(strict_types=1);

namespace Tests\Unit;

use Montonio\Structs\OrderData;
use stdClass;
use Tests\BaseTestCase;

class MontonioClientTest extends BaseTestCase
{
    public function testJwt()
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
}
