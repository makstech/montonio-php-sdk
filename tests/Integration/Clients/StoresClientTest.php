<?php

declare(strict_types=1);

namespace Tests\Integration\Clients;

use Tests\BaseTestCase;

class StoresClientTest extends BaseTestCase
{
    public function testGetPaymentMethods(): void
    {
        $methods = $this->getMontonioClient()->stores()->getPaymentMethods();

        $this->assertIsArray($methods['paymentMethods']['paymentInitiation']['setup']['LV']['paymentMethods']);
    }
}
