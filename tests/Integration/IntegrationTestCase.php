<?php

declare(strict_types=1);

namespace Tests\Integration;

use Tests\BaseTestCase;

abstract class IntegrationTestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        if (empty(ACCESS_KEY)) {
            $this->markTestSkipped('Integration tests require ACCESS_KEY and SECRET_KEY env variables.');
        }
    }
}
