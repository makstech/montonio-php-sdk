<?php

declare(strict_types=1);

namespace Tests\Unit\Structs;

use Montonio\Structs\CreateRefundData;
use Tests\BaseTestCase;

class CreateRefundDataTest extends BaseTestCase
{
    public function testFluentSettersAndGetters(): void
    {
        $data = (new CreateRefundData())
            ->setOrderUuid('12228dce-2f7c-4db5-8d28-5d82a19aa3b6')
            ->setAmount(25.00)
            ->setIdempotencyKey('a1b2c3d4-e5f6-7890-abcd-ef1234567890');

        $this->assertSame('12228dce-2f7c-4db5-8d28-5d82a19aa3b6', $data->getOrderUuid());
        $this->assertSame(25.00, $data->getAmount());
        $this->assertSame('a1b2c3d4-e5f6-7890-abcd-ef1234567890', $data->getIdempotencyKey());
    }

    public function testToArray(): void
    {
        $data = (new CreateRefundData())
            ->setOrderUuid('12228dce-2f7c-4db5-8d28-5d82a19aa3b6')
            ->setAmount(25.00)
            ->setIdempotencyKey('a1b2c3d4-e5f6-7890-abcd-ef1234567890');

        $array = $data->toArray();

        $this->assertSame('12228dce-2f7c-4db5-8d28-5d82a19aa3b6', $array['orderUuid']);
        $this->assertSame(25.00, $array['amount']);
        $this->assertSame('a1b2c3d4-e5f6-7890-abcd-ef1234567890', $array['idempotencyKey']);
    }

    public function testConstructFromArray(): void
    {
        $data = new CreateRefundData([
            'orderUuid' => '12228dce-2f7c-4db5-8d28-5d82a19aa3b6',
            'amount' => 19.99,
            'idempotencyKey' => 'key-123',
        ]);

        $this->assertSame('12228dce-2f7c-4db5-8d28-5d82a19aa3b6', $data->getOrderUuid());
        $this->assertSame(19.99, $data->getAmount());
        $this->assertSame('key-123', $data->getIdempotencyKey());
    }

    public function testNullableGetters(): void
    {
        $data = new CreateRefundData();

        $this->assertNull($data->getOrderUuid());
        $this->assertNull($data->getAmount());
        $this->assertNull($data->getIdempotencyKey());
    }
}
