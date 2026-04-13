<?php

declare(strict_types=1);

namespace Tests\Unit\Exception;

use Montonio\Exception\ApiException;
use Montonio\Exception\AuthenticationException;
use Montonio\Exception\CurlErrorException;
use Montonio\Exception\MontonioException;
use Montonio\Exception\NotFoundException;
use Montonio\Exception\RateLimitException;
use Montonio\Exception\RequestException;
use Montonio\Exception\ServerException;
use Montonio\Exception\TransportException;
use Montonio\Exception\ValidationException;
use Tests\BaseTestCase;

class ExceptionHierarchyTest extends BaseTestCase
{
    public function testApiExceptionExtensionChain(): void
    {
        $e = new ApiException('test', 400, '{"error":"bad"}');

        $this->assertInstanceOf(RequestException::class, $e);
        $this->assertInstanceOf(MontonioException::class, $e);
        $this->assertSame(400, $e->getStatusCode());
        $this->assertSame('{"error":"bad"}', $e->getResponseBody());
        $this->assertNull($e->getCurlHandle());
    }

    public function testSpecificExceptionsExtendApiAndRequest(): void
    {
        $exceptions = [
            new AuthenticationException('', 401),
            new ValidationException('', 400),
            new NotFoundException('', 404),
            new RateLimitException('', 429),
            new ServerException('', 500),
        ];

        foreach ($exceptions as $e) {
            $this->assertInstanceOf(ApiException::class, $e);
            $this->assertInstanceOf(RequestException::class, $e, get_class($e) . ' must extend RequestException for BC');
            $this->assertInstanceOf(MontonioException::class, $e);
        }
    }

    public function testTransportExceptionExtensionChain(): void
    {
        $e = new TransportException('connection failed', 7);

        $this->assertInstanceOf(CurlErrorException::class, $e);
        $this->assertInstanceOf(MontonioException::class, $e);
        $this->assertSame('connection failed', $e->getMessage());
        $this->assertNull($e->getCurlHandle());
    }

    public function testRequestExceptionBcMethods(): void
    {
        $e = new RequestException('not found', 404, '{"error":"not found"}');

        $this->assertInstanceOf(MontonioException::class, $e);
        $this->assertSame(404, $e->getStatusCode());
        $this->assertSame('{"error":"not found"}', $e->getResponseBody());
        $this->assertSame('{"error":"not found"}', $e->getResponse());
        $this->assertNull($e->curlHandle());
    }

    public function testCurlErrorExceptionBcMethods(): void
    {
        $e = new CurlErrorException('timeout', 28);

        $this->assertInstanceOf(MontonioException::class, $e);
        $this->assertNull($e->getCurlHandle());
    }

    public function testCatchRequestExceptionCatchesApiExceptions(): void
    {
        $caught = false;

        try {
            throw new ValidationException('bad', 400, '{}');
        } catch (RequestException $e) {
            $caught = true;
        }

        $this->assertTrue($caught, 'catch (RequestException) must catch ValidationException for BC');
    }

    public function testCatchCurlErrorExceptionCatchesTransportException(): void
    {
        $caught = false;

        try {
            throw new TransportException('fail', 7);
        } catch (CurlErrorException $e) {
            $caught = true;
        }

        $this->assertTrue($caught, 'catch (CurlErrorException) must catch TransportException for BC');
    }
}
