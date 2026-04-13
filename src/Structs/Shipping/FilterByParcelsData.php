<?php

declare(strict_types=1);

namespace Montonio\Structs\Shipping;

use Montonio\Structs\AbstractStruct;

/**
 * Request data for filtering shipping methods by parcel dimensions.
 *
 * @see https://docs.montonio.com/api/shipping-v2/reference#get-possible-shipping-methods-for-given-parcels
 */
class FilterByParcelsData extends AbstractStruct
{
    /** @var ShipmentParcel[] */
    protected array $parcels = [];

    public function getParcels(): ?array
    {
        return $this->parcels ?? null;
    }

    /**
     * @param ShipmentParcel[] $parcels
     */
    public function setParcels(array $parcels): self
    {
        foreach ($parcels as $key => $parcel) {
            if (is_array($parcel)) {
                $parcels[$key] = new ShipmentParcel($parcel);
            }
        }

        $this->parcels = $parcels;

        return $this;
    }
}
