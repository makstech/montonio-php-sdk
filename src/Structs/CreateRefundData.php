<?php

declare(strict_types=1);

namespace Montonio\Structs;

use Montonio\Structs\Fields\Amount;

class CreateRefundData extends AbstractStruct
{
    use Amount;

    protected string $orderUuid;
    protected string $idempotencyKey;

    /**
     * The UUID of the Montonio order to refund.
     */
    public function getOrderUuid(): ?string
    {
        return $this->orderUuid ?? null;
    }

    /**
     * The UUID of the Montonio order to refund.
     */
    public function setOrderUuid(string $orderUuid): self
    {
        $this->orderUuid = $orderUuid;

        return $this;
    }

    /**
     * Unique key to prevent duplicate refunds. V4 UUID recommended.
     */
    public function getIdempotencyKey(): ?string
    {
        return $this->idempotencyKey ?? null;
    }

    /**
     * Unique key to prevent duplicate refunds. V4 UUID recommended.
     */
    public function setIdempotencyKey(string $idempotencyKey): self
    {
        $this->idempotencyKey = $idempotencyKey;

        return $this;
    }
}
