<?php

declare(strict_types=1);

namespace Montonio\Clients\Shipping;

use Montonio\Clients\ShippingAbstractClient;
use Montonio\Structs\Shipping\CreateLabelFileData;

/**
 * @see https://docs.montonio.com/api/shipping-v2/guides/labels
 *
 */
class LabelFilesClient extends ShippingAbstractClient
{
    /**
     * Create a label file for one or more shipments.
     *
     * Use synchronous: true to get the download URL in the response immediately.
     * Label URLs expire after 5 minutes — use getLabelFile() to get a fresh URL.
     */
    public function createLabelFile(CreateLabelFileData $data): array
    {
        return $this->post('label-files', $data->toArray());
    }

    /**
     * Get label file status and download URL. Use this to get a fresh URL after expiry.
     */
    public function getLabelFile(string $labelFileId): array
    {
        return $this->get('label-files/' . $labelFileId);
    }
}
