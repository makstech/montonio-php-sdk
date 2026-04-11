<?php

declare(strict_types=1);

namespace Tests\Integration\Clients;

use Tests\Integration\IntegrationTestCase;

class StoresClientTest extends IntegrationTestCase
{
    public function testGetPaymentMethods(): void
    {
        $methods = $this->getMontonioClient()->stores()->getPaymentMethods();

        $this->assertIsArray($methods['paymentMethods']['paymentInitiation']['setup']['LV']['paymentMethods']);
    }
}
