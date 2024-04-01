<?php

declare(strict_types=1);

namespace Montonio\Exception;

use CurlHandle;
use Throwable;

class RequestException extends MontonioException
{
    private string $response;
    private ?CurlHandle $curlHandle;

    public function __construct(
        string $message = '',
        int $code = 0,
        string $response = '',
        ?CurlHandle $curlHandle = null,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);

        $this->response = $response;
        $this->curlHandle = $curlHandle;
    }

    public function getResponse(): string
    {
        return $this->response;
    }

    public function curlHandle(): CurlHandle
    {
        return $this->curlHandle;
    }
}
