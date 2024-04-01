<?php

declare(strict_types=1);

namespace Tests;

use Montonio\MontonioClient;
use PHPUnit\Framework\TestCase;

abstract class BaseTestCase extends TestCase
{
    protected function getMontonioClient(): MontonioClient
    {
        return new MontonioClient(ACCESS_KEY, SECRET_KEY, MontonioClient::ENVIRONMENT_SANDBOX);
    }
}
