<?php

declare(strict_types=1);

namespace Tests\Unit\Enums;

use Montonio\Enums\Environment;
use Montonio\MontonioClient;
use Tests\BaseTestCase;

class EnvironmentTest extends BaseTestCase
{
    public function testValues(): void
    {
        $this->assertSame('sandbox', Environment::Sandbox->value);
        $this->assertSame('live', Environment::Live->value);
    }

    public function testMatchesDeprecatedConstants(): void
    {
        $this->assertSame(MontonioClient::ENVIRONMENT_SANDBOX, Environment::Sandbox->value);
        $this->assertSame(MontonioClient::ENVIRONMENT_LIVE, Environment::Live->value);
    }
}
