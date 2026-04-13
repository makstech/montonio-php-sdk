<?php

declare(strict_types=1);

namespace Montonio\Exception;

use CurlHandle;
use Throwable;

/**
 * @deprecated Use ApiException or its subclasses instead. Will be removed in v3.
 */
class RequestException extends MontonioException
{
    public function __construct(
        string $message = '',
        int $code = 0,
        private readonly string $responseBody = '',
        private readonly ?CurlHandle $curlHandle = null,
        ?Throwable $previous = null,
    ) {
        parent::__construct($message, $code, $previous);
    }

    public function getStatusCode(): int
    {
        return $this->getCode();
    }

    public function getResponseBody(): string
    {
        return $this->responseBody;
    }

    public function getCurlHandle(): ?CurlHandle
    {
        return $this->curlHandle;
    }

    /**
     * @deprecated Use getResponseBody() instead. Will be removed in v3.
     */
    public function getResponse(): string
    {
        return $this->responseBody;
    }

    /**
     * @deprecated Use getCurlHandle() instead. Will be removed in v3.
     */
    public function curlHandle(): ?CurlHandle
    {
        return $this->curlHandle;
    }
}
