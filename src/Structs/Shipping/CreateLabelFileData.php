<?php

declare(strict_types=1);

namespace Montonio\Structs\Shipping;

use Montonio\Structs\AbstractStruct;

/**
 * Request data for creating a label file.
 *
 * @see https://docs.montonio.com/api/shipping-v2/reference#create-a-label-file
 */
class CreateLabelFileData extends AbstractStruct
{
    /** @var string[] */
    protected array $shipmentIds = [];
    protected string $pageSize;
    protected int $labelsPerPage;
    protected string $orderLabelsBy;
    protected bool $synchronous;

    public function getShipmentIds(): ?array
    {
        return $this->shipmentIds ?? null;
    }

    /**
     * @param string[] $shipmentIds
     */
    public function setShipmentIds(array $shipmentIds): self
    {
        $this->shipmentIds = $shipmentIds;

        return $this;
    }

    public function getPageSize(): ?string
    {
        return $this->pageSize ?? null;
    }

    public function setPageSize(string $pageSize): self
    {
        $this->pageSize = $pageSize;

        return $this;
    }

    public function getLabelsPerPage(): ?int
    {
        return $this->labelsPerPage ?? null;
    }

    public function setLabelsPerPage(int $labelsPerPage): self
    {
        $this->labelsPerPage = $labelsPerPage;

        return $this;
    }

    public function getOrderLabelsBy(): ?string
    {
        return $this->orderLabelsBy ?? null;
    }

    public function setOrderLabelsBy(string $orderLabelsBy): self
    {
        $this->orderLabelsBy = $orderLabelsBy;

        return $this;
    }

    public function getSynchronous(): ?bool
    {
        return $this->synchronous ?? null;
    }

    public function setSynchronous(bool $synchronous): self
    {
        $this->synchronous = $synchronous;

        return $this;
    }
}
