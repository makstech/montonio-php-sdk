<?php

declare(strict_types=1);

namespace Tests\Integration\Clients;

use Montonio\Exception\RequestException;
use Montonio\Structs\CreateRefundData;
use Tests\BaseTestCase;

class RefundsClientTest extends BaseTestCase
{
    public function testCreateRefund_fails_invalidOrder(): void
    {
        $data = (new CreateRefundData())
            ->setOrderUuid('00000000-0000-0000-0000-000000000000')
            ->setAmount(1.00)
            ->setIdempotencyKey(uniqid('test-', true));

        $this->expectException(RequestException::class);

        $this->getMontonioClient()->refunds()->createRefund($data);
    }
}
