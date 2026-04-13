<?php

declare(strict_types=1);

namespace Montonio;

use Montonio\Clients\OrdersClient;
use Montonio\Clients\PaymentsAbstractClient;
use Montonio\Clients\Shipping\ShippingClient;
use Montonio\Clients\PaymentIntentsClient;
use Montonio\Clients\PaymentLinksClient;
use Montonio\Clients\PayoutsClient;
use Montonio\Clients\RefundsClient;
use Montonio\Clients\SessionsClient;
use Montonio\Clients\StoresClient;

class MontonioClient extends PaymentsAbstractClient
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

    public function paymentIntents(): PaymentIntentsClient
    {
        return new PaymentIntentsClient(
            $this->getAccessKey(),
            $this->getSecretKey(),
            $this->getEnvironment(),
        );
    }

    public function paymentLinks(): PaymentLinksClient
    {
        return new PaymentLinksClient(
            $this->getAccessKey(),
            $this->getSecretKey(),
            $this->getEnvironment(),
        );
    }

    public function payouts(): PayoutsClient
    {
        return new PayoutsClient(
            $this->getAccessKey(),
            $this->getSecretKey(),
            $this->getEnvironment(),
        );
    }

    public function refunds(): RefundsClient
    {
        return new RefundsClient(
            $this->getAccessKey(),
            $this->getSecretKey(),
            $this->getEnvironment(),
        );
    }

    public function sessions(): SessionsClient
    {
        return new SessionsClient(
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

    public function shipping(): ShippingClient
    {
        return new ShippingClient(
            $this->getAccessKey(),
            $this->getSecretKey(),
            $this->getEnvironment(),
        );
    }
}
