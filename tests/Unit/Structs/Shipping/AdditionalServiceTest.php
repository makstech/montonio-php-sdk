<?php

declare(strict_types=1);

namespace Tests\Unit\Structs\Shipping;

use Montonio\Structs\Shipping\AdditionalService;
use Montonio\Structs\Shipping\AdditionalServiceParams;
use Tests\BaseTestCase;

class AdditionalServiceTest extends BaseTestCase
{
    public function testFluentSetters(): void
    {
        $service = (new AdditionalService())
            ->setCode('cod')
            ->setParams(
                (new AdditionalServiceParams())->setAmount(25.50)
            );

        $this->assertSame('cod', $service->getCode());
        $this->assertSame(25.50, $service->getParams()->getAmount());
    }

    public function testToArray(): void
    {
        $service = (new AdditionalService())
            ->setCode('cod')
            ->setParams(
                (new AdditionalServiceParams())->setAmount(10.00)
            );

        $array = $service->toArray();

        $this->assertSame('cod', $array['code']);
        $this->assertSame(10.00, $array['params']['amount']);
    }

    public function testConstructFromArray(): void
    {
        $service = new AdditionalService([
            'code' => 'ageVerification',
        ]);

        $this->assertSame('ageVerification', $service->getCode());
        $this->assertNull($service->getParams());
    }

    public function testNullableGetters(): void
    {
        $service = new AdditionalService();

        $this->assertNull($service->getCode());
        $this->assertNull($service->getParams());
    }
}
