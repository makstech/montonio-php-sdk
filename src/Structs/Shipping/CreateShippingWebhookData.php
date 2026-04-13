<?php

declare(strict_types=1);

namespace Montonio\Structs\Shipping;

use Montonio\Structs\AbstractStruct;

/**
 * Request data for creating a shipping webhook.
 *
 * @see https://docs.montonio.com/api/shipping-v2/reference#create-webhooks
 */
class CreateShippingWebhookData extends AbstractStruct
{
    protected string $url;
    /** @var string[] */
    protected array $enabledEvents = [];

    public function getUrl(): ?string
    {
        return $this->url ?? null;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getEnabledEvents(): ?array
    {
        return $this->enabledEvents ?? null;
    }

    /**
     * @param string[] $enabledEvents
     */
    public function setEnabledEvents(array $enabledEvents): self
    {
        $this->enabledEvents = $enabledEvents;

        return $this;
    }
}
