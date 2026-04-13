<?php

declare(strict_types=1);

namespace Montonio\Structs\Shipping;

use Montonio\Structs\AbstractStruct;

class RatesParcel extends AbstractStruct
{
    /** @var RatesItem[] */
    protected array $items = [];

    public function getItems(): ?array
    {
        return $this->items ?? null;
    }

    /**
     * @param RatesItem[] $items
     */
    public function setItems(array $items): self
    {
        foreach ($items as $key => $item) {
            if (is_array($item)) {
                $items[$key] = new RatesItem($item);
            }
        }

        $this->items = $items;

        return $this;
    }
}
