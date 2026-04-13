<?php

declare(strict_types=1);

namespace Tests\Unit\Clients;

use Montonio\Exception\ApiException;
use Montonio\Exception\AuthenticationException;
use Montonio\Exception\NotFoundException;
use Montonio\Exception\RateLimitException;
use Montonio\Exception\ServerException;
use Montonio\Exception\TransportException;
use Montonio\Exception\ValidationException;
use Montonio\MontonioClient;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\StreamInterface;
use Tests\BaseTestCase;

class PsrClientTest extends BaseTestCase
{
    public function testConstructorRequiresFactoriesWithHttpClient(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        new MontonioClient(
            ACCESS_KEY,
            SECRET_KEY,
            'sandbox',
            $this->createStub(ClientInterface::class),
        );
    }

    public function testConstructorAcceptsFullPsrTrio(): void
    {
        $client = new MontonioClient(
            ACCESS_KEY,
            SECRET_KEY,
            'sandbox',
            $this->createStub(ClientInterface::class),
            $this->createStub(RequestFactoryInterface::class),
            $this->createStub(StreamFactoryInterface::class),
        );

        $this->assertInstanceOf(MontonioClient::class, $client);
    }

    public function testConstructorWorksWithoutPsr(): void
    {
        $client = new MontonioClient(ACCESS_KEY, SECRET_KEY, 'sandbox');

        $this->assertInstanceOf(MontonioClient::class, $client);
    }

    private function createPsrClient(int $statusCode, string $body): MontonioClient
    {
        $stream = $this->createStub(StreamInterface::class);
        $stream->method('__toString')->willReturn($body);

        $response = $this->createStub(ResponseInterface::class);
        $response->method('getStatusCode')->willReturn($statusCode);
        $response->method('getBody')->willReturn($stream);

        $httpClient = $this->createStub(ClientInterface::class);
        $httpClient->method('sendRequest')->willReturn($response);

        $request = $this->createStub(RequestInterface::class);
        $request->method('withHeader')->willReturn($request);
        $request->method('withBody')->willReturn($request);

        $requestFactory = $this->createStub(RequestFactoryInterface::class);
        $requestFactory->method('createRequest')->willReturn($request);

        $streamFactory = $this->createStub(StreamFactoryInterface::class);
        $streamFactory->method('createStream')->willReturn($stream);

        return new MontonioClient(
            ACCESS_KEY,
            SECRET_KEY,
            'sandbox',
            $httpClient,
            $requestFactory,
            $streamFactory,
        );
    }

    public function testPsr18SuccessfulGetResponse(): void
    {
        $client = $this->createPsrClient(200, '{"paymentMethods":[]}');

        $result = $client->stores()->getPaymentMethods();

        $this->assertIsArray($result);
        $this->assertArrayHasKey('paymentMethods', $result);
    }

    public function testPsr18SuccessfulPostResponse(): void
    {
        $client = $this->createPsrClient(200, '{"uuid":"test-uuid"}');

        $result = $client->sessions()->createSession();

        $this->assertIsArray($result);
        $this->assertArrayHasKey('uuid', $result);
    }

    public function testPsr18TransportException(): void
    {
        $exception = new class ('connection failed') extends \RuntimeException implements ClientExceptionInterface {};

        $httpClient = $this->createStub(ClientInterface::class);
        $httpClient->method('sendRequest')->willThrowException($exception);

        $request = $this->createStub(RequestInterface::class);
        $request->method('withHeader')->willReturn($request);
        $request->method('withBody')->willReturn($request);

        $requestFactory = $this->createStub(RequestFactoryInterface::class);
        $requestFactory->method('createRequest')->willReturn($request);

        $streamFactory = $this->createStub(StreamFactoryInterface::class);

        $client = new MontonioClient(
            ACCESS_KEY,
            SECRET_KEY,
            'sandbox',
            $httpClient,
            $requestFactory,
            $streamFactory,
        );

        $this->expectException(TransportException::class);
        $this->expectExceptionMessage('connection failed');
        $client->stores()->getPaymentMethods();
    }

    public function testPsr18AuthenticationException(): void
    {
        $client = $this->createPsrClient(401, '{"error":"unauthorized"}');

        $this->expectException(AuthenticationException::class);
        $client->stores()->getPaymentMethods();
    }

    public function testPsr18ValidationException(): void
    {
        $client = $this->createPsrClient(400, '{"error":"bad request"}');

        $this->expectException(ValidationException::class);
        $client->stores()->getPaymentMethods();
    }

    public function testPsr18NotFoundException(): void
    {
        $client = $this->createPsrClient(404, '{"error":"not found"}');

        $this->expectException(NotFoundException::class);
        $client->stores()->getPaymentMethods();
    }

    public function testPsr18ServerException(): void
    {
        $client = $this->createPsrClient(500, '{"error":"internal"}');

        $this->expectException(ServerException::class);
        $client->stores()->getPaymentMethods();
    }

    public function testPsr18RateLimitException(): void
    {
        $client = $this->createPsrClient(429, '{"error":"too many requests"}');

        $this->expectException(RateLimitException::class);
        $client->stores()->getPaymentMethods();
    }

    public function testPsr18ForbiddenThrowsAuthenticationException(): void
    {
        $client = $this->createPsrClient(403, '{"error":"forbidden"}');

        $this->expectException(AuthenticationException::class);
        $client->stores()->getPaymentMethods();
    }

    public function testPsr18UnprocessableEntityThrowsValidationException(): void
    {
        $client = $this->createPsrClient(422, '{"error":"unprocessable"}');

        $this->expectException(ValidationException::class);
        $client->stores()->getPaymentMethods();
    }

    public function testPsr18UnmappedStatusThrowsApiException(): void
    {
        $client = $this->createPsrClient(409, '{"error":"conflict"}');

        $this->expectException(ApiException::class);
        $client->stores()->getPaymentMethods();
    }

    public function testPsr18EmptyResponseReturnsEmptyArray(): void
    {
        $client = $this->createPsrClient(204, '');

        $result = $client->stores()->getPaymentMethods();

        $this->assertSame([], $result);
    }
}
