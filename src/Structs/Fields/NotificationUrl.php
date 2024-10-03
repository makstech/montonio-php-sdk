<?php

declare(strict_types=1);

namespace Montonio\Structs\Fields;

trait NotificationUrl
{
    protected string $notificationUrl;

    /**
     * The URL to send a webhook notification about Order updates, e.g when a payment is completed.
     */
    public function getNotificationUrl(): ?string
    {
        return $this->notificationUrl ?? null;
    }

    /**
     * The URL to send a webhook notification about Order updates, e.g when a payment is completed.
     */
    public function setNotificationUrl(string $notificationUrl): self
    {
        $this->notificationUrl = $notificationUrl;

        return $this;
    }
}
