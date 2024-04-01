<?php

declare(strict_types=1);

namespace Montonio\Exception;

use CurlHandle;
use Throwable;

class CurlErrorException extends MontonioException
{
    private ?CurlHandle $curlHandle;

    public function __construct(
        string $message = '',
        int $code = 0,
        CurlHandle $ch = null,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);

        $this->curlHandle = $ch;
    }

    public function getCurlHandle(): ?CurlHandle
    {
        return $this->curlHandle;
    }
}
