<?php

declare(strict_types=1);

namespace Montonio\Structs\Shipping;

use Montonio\Structs\AbstractStruct;

/**
 * Request data for calculating shipping rates.
 *
 * @see https://docs.montonio.com/api/shipping-v2/reference#calculate-shipping-rates
 */
class ShippingRatesData extends AbstractStruct
{
    protected string $destination;
    /** @var RatesParcel[] */
    protected array $parcels = [];

    public function getDestination(): ?string
    {
        return $this->destination ?? null;
    }

    public function setDestination(string $destination): self
    {
        $this->destination = $destination;

        return $this;
    }

    public function getParcels(): ?array
    {
        return $this->parcels ?? null;
    }

    /**
     * @param RatesParcel[] $parcels
     */
    public function setParcels(array $parcels): self
    {
        foreach ($parcels as $key => $parcel) {
            if (is_array($parcel)) {
                $parcels[$key] = new RatesParcel($parcel);
            }
        }

        $this->parcels = $parcels;

        return $this;
    }
}
