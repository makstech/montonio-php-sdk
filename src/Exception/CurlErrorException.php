<?php

declare(strict_types=1);

namespace Montonio\Exception;

use CurlHandle;
use Throwable;

/**
 * @deprecated Use TransportException instead. Will be removed in v3.
 */
class CurlErrorException extends MontonioException
{
    public function __construct(
        string $message = '',
        int $code = 0,
        private readonly ?CurlHandle $curlHandle = null,
        ?Throwable $previous = null,
    ) {
        parent::__construct($message, $code, $previous);
    }

    public function getCurlHandle(): ?CurlHandle
    {
        return $this->curlHandle;
    }
}
