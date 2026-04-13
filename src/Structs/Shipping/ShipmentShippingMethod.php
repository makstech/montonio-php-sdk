<?php

declare(strict_types=1);

namespace Montonio\Structs\Shipping;

use Montonio\Structs\AbstractStruct;

class ShipmentShippingMethod extends AbstractStruct
{
    protected string $type;
    protected string $id;
    /** @var AdditionalService[] */
    protected array $additionalServices = [];
    protected string $parcelHandoverMethod;
    protected string $lockerSize;

    public function getType(): ?string
    {
        return $this->type ?? null;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getId(): ?string
    {
        return $this->id ?? null;
    }

    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getAdditionalServices(): ?array
    {
        return $this->additionalServices ?? null;
    }

    /**
     * @param AdditionalService[] $additionalServices
     */
    public function setAdditionalServices(array $additionalServices): self
    {
        foreach ($additionalServices as $key => $service) {
            if (is_array($service)) {
                $additionalServices[$key] = new AdditionalService($service);
            }
        }

        $this->additionalServices = $additionalServices;

        return $this;
    }

    public function getParcelHandoverMethod(): ?string
    {
        return $this->parcelHandoverMethod ?? null;
    }

    public function setParcelHandoverMethod(string $parcelHandoverMethod): self
    {
        $this->parcelHandoverMethod = $parcelHandoverMethod;

        return $this;
    }

    public function getLockerSize(): ?string
    {
        return $this->lockerSize ?? null;
    }

    public function setLockerSize(string $lockerSize): self
    {
        $this->lockerSize = $lockerSize;

        return $this;
    }
}
