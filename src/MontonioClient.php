<?php

declare(strict_types=1);

namespace Montonio;

use Montonio\Clients\AbstractClient;
use Montonio\Clients\OrdersClient;
use Montonio\Clients\StoresClient;

class MontonioClient extends AbstractClient
{
    public const ENVIRONMENT_SANDBOX = 'sandbox';
    public const ENVIRONMENT_LIVE = 'live';

    public function orders(): OrdersClient
    {
        return new OrdersClient(
            $this->getAccessKey(),
            $this->getSecretKey(),
            $this->getEnvironment(),
        );
    }

    public function stores(): StoresClient
    {
        return new StoresClient(
            $this->getAccessKey(),
            $this->getSecretKey(),
            $this->getEnvironment(),
        );
    }
}
