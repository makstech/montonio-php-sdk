<?php

declare(strict_types=1);

namespace Montonio\Clients;

class PayoutsClient extends AbstractClient
{
    /**
     * List payouts for a store.
     *
     * @param string $storeUuid  Your store UUID from the Partner System
     * @param int    $limit      Max number of results (max 150)
     * @param int    $offset     Pagination offset
     * @param string $order      Sort direction: 'ASC' or 'DESC'
     * @param string|null $orderBy Sort field: 'createdAt', 'settlementType', 'totalAmount', 'status'
     */
    public function getPayouts(
        string $storeUuid,
        int $limit = 50,
        int $offset = 0,
        string $order = 'DESC',
        ?string $orderBy = null
    ): array {
        $params = [
            'limit' => $limit,
            'offset' => $offset,
            'order' => $order,
        ];

        if ($orderBy !== null) {
            $params['orderBy'] = $orderBy;
        }

        $query = http_build_query($params);

        return $this->get('stores/' . $storeUuid . '/payouts?' . $query);
    }

    /**
     * Export a payout report.
     *
     * @param string $storeUuid  Your store UUID
     * @param string $payoutUuid The payout UUID
     * @param string $format     Export format: 'excel' or 'xml'
     * @return array Contains 'url' with a pre-signed download link
     *
     * @codeCoverageIgnore Requires actual payouts in the sandbox which can't be created via API
     */
    public function exportPayout(string $storeUuid, string $payoutUuid, string $format = 'excel'): array
    {
        return $this->get('stores/' . $storeUuid . '/payouts/' . $payoutUuid . '/export-' . $format);
    }

    /**
     * Get payout balances for your store.
     */
    public function getBalances(): array
    {
        return $this->get('store-balances');
    }
}
