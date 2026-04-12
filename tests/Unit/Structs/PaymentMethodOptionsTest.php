<?php

declare(strict_types=1);

namespace Tests\Unit\Structs;

use Montonio\Structs\PaymentMethodOptions;
use Tests\BaseTestCase;

class PaymentMethodOptionsTest extends BaseTestCase
{
    public function testBlikCode(): void
    {
        $options = (new PaymentMethodOptions())
            ->setBlikCode('777123');

        $this->assertSame('777123', $options->getBlikCode());

        $array = $options->toArray();
        $this->assertSame('777123', $array['blikCode']);
    }

    public function testBlikCodeNullable(): void
    {
        $options = new PaymentMethodOptions();

        $this->assertNull($options->getBlikCode());
    }

    public function testBlikCodeFromArray(): void
    {
        $options = new PaymentMethodOptions([
            'blikCode' => '555555',
        ]);

        $this->assertSame('555555', $options->getBlikCode());
    }
}
