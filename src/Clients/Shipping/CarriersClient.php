<?php

declare(strict_types=1);

namespace Montonio\Clients\Shipping;

use Montonio\Clients\ShippingAbstractClient;

/**
 * @see https://docs.montonio.com/api/shipping-v2/reference#get-all-carriers
 */
class CarriersClient extends ShippingAbstractClient
{
    /**
     * Fetch all carriers available through Montonio Shipping.
     */
    public function getCarriers(): array
    {
        return $this->get('carriers');
    }
}
