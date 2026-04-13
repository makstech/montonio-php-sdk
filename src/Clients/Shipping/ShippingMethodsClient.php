<?php

declare(strict_types=1);

namespace Montonio\Clients\Shipping;

use Montonio\Clients\ShippingAbstractClient;
use Montonio\Structs\Shipping\FilterByParcelsData;
use Montonio\Structs\Shipping\ShippingRatesData;

/**
 * @see https://docs.montonio.com/api/shipping-v2/guides/shipping-methods
 */
class ShippingMethodsClient extends ShippingAbstractClient
{
    /**
     * Fetch all shipping methods available for your store, grouped by country and carrier.
     */
    public function getShippingMethods(): array
    {
        return $this->get('shipping-methods');
    }

    /**
     * Fetch pickup points (parcel machines, post offices, parcel shops) for a carrier and country.
     *
     * @param string      $carrierCode Carrier code (e.g. 'omniva', 'dpd')
     * @param string      $countryCode ISO country code (e.g. 'EE', 'LT')
     * @param string|null $type        Filter by type: 'parcelMachine', 'postOffice', or 'parcelShop'
     */
    public function getPickupPoints(string $carrierCode, string $countryCode, ?string $type = null): array
    {
        $params = [
            'carrierCode' => $carrierCode,
            'countryCode' => $countryCode,
        ];

        if ($type !== null) {
            $params['type'] = $type;
        }

        return $this->get('shipping-methods/pickup-points', $params);
    }

    /**
     * Fetch courier services for a carrier and country.
     *
     * @param string $carrierCode Carrier code (e.g. 'dpd', 'omniva')
     * @param string $countryCode ISO country code (e.g. 'EE', 'LT')
     */
    public function getCourierServices(string $carrierCode, string $countryCode): array
    {
        return $this->get('shipping-methods/courier-services', [
            'carrierCode' => $carrierCode,
            'countryCode' => $countryCode,
        ]);
    }

    /**
     * Filter available shipping methods by parcel dimensions and destination.
     *
     * @param string      $destination Destination country code (e.g. 'EE')
     * @param string|null $source      Source country code
     */
    public function filterByParcels(FilterByParcelsData $data, string $destination, ?string $source = null): array
    {
        $queryParams = ['destination' => $destination];

        if ($source !== null) {
            $queryParams['source'] = $source;
        }

        return $this->post('shipping-methods/filter-by-parcels', $data->toArray(), $queryParams);
    }

    /**
     * Calculate shipping rates for given parcels and destination.
     *
     * Only returns rates for carriers with Montonio contracts.
     *
     * @param string|null $carrierCode        Filter by carrier code
     * @param string|null $shippingMethodType Filter by type: 'courier' or 'pickupPoint'
     */
    public function getRates(ShippingRatesData $data, ?string $carrierCode = null, ?string $shippingMethodType = null): array
    {
        $queryParams = [];

        if ($carrierCode !== null) {
            $queryParams['carrierCode'] = $carrierCode;
        }

        if ($shippingMethodType !== null) {
            $queryParams['shippingMethodType'] = $shippingMethodType;
        }

        return $this->post('shipping-methods/rates', $data->toArray(), $queryParams);
    }
}
