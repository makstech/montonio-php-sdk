# Upgrading from v1 to v2

For most users, **upgrading is seamless** — your existing code will work without changes. The public API (structs, factory methods, array responses, webhook decoding) is unchanged. v2 focuses on modernization: PSR-18 support, enums, and a richer exception hierarchy.

The only hard requirement is **PHP 8.2+**. Beyond that, v2 introduces several deprecations (old exception classes, string constants) that still work but should be migrated before v3.

## Requirements

- **PHP 8.2+** is now required (was 8.0+).

## Installation

```shell
composer require makstech/montonio-php-sdk:^2.0
```

## Breaking Changes

### Exception classes

`CurlErrorException` has been renamed to `TransportException`. The old class still exists as a deprecated alias — existing `catch` blocks will continue to work.

`RequestException` is now a deprecated alias for `ApiException`. Existing `catch (RequestException $e)` blocks still work.

New specific exception types are available for more precise error handling:

```php
use Montonio\Exception\AuthenticationException; // 401, 403
use Montonio\Exception\ValidationException;     // 400, 422
use Montonio\Exception\NotFoundException;       // 404
use Montonio\Exception\RateLimitException;      // 429
use Montonio\Exception\ServerException;         // 500+
use Montonio\Exception\ApiException;            // base for all API errors
use Montonio\Exception\TransportException;      // network/transport failures
```

### CurlHandle nullable

`ApiException::getCurlHandle()` returns `?CurlHandle` instead of `CurlHandle`. It is `null` when using a PSR-18 HTTP client.

## Deprecations

The following are deprecated in v2 and will be removed in v3:

### Constants replaced by Enums

| Deprecated Constant | Use Instead |
|---|---|
| `MontonioClient::ENVIRONMENT_SANDBOX` | `Environment::Sandbox` |
| `MontonioClient::ENVIRONMENT_LIVE` | `Environment::Live` |
| `Payment::METHOD_PAYMENT_INITIATION` | `PaymentMethod::PaymentInitiation` |
| `Payment::METHOD_CARD` | `PaymentMethod::CardPayments` |
| `Payment::METHOD_BLIK` | `PaymentMethod::Blik` |
| `Payment::METHOD_HIRE_PURCHASE` | `PaymentMethod::HirePurchase` |
| `Payment::METHOD_BUY_NOW_PAY_LATER` | `PaymentMethod::BuyNowPayLater` |
| `OrderData::STATUS_PENDING` | `PaymentStatus::Pending` |
| `OrderData::STATUS_PAID` | `PaymentStatus::Paid` |
| `OrderData::STATUS_VOIDED` | `PaymentStatus::Voided` |
| `OrderData::STATUS_PARTIALLY_REFUNDED` | `PaymentStatus::PartiallyRefunded` |
| `OrderData::STATUS_REFUNDED` | `PaymentStatus::Refunded` |
| `OrderData::STATUS_ABANDONED` | `PaymentStatus::Abandoned` |
| `OrderData::STATUS_AUTHORIZED` | `PaymentStatus::Authorized` |

### Exception classes

| Deprecated Class | Use Instead |
|---|---|
| `RequestException` | `ApiException` |
| `CurlErrorException` | `TransportException` |

### Exception methods

| Deprecated Method | Use Instead |
|---|---|
| `$e->getResponse()` | `$e->getResponseBody()` |
| `$e->curlHandle()` | `$e->getCurlHandle()` |

## New Features

### PSR-18 HTTP Client Support

You can now inject a custom PSR-18 HTTP client instead of using the built-in cURL transport:

```php
$client = new MontonioClient(
    $accessKey,
    $secretKey,
    'live',
    httpClient: $yourPsr18Client,
    requestFactory: $yourPsr17RequestFactory,
    streamFactory: $yourPsr17StreamFactory,
);
```

### Static `create()` Factory

All structs now support a `create()` static factory with named parameters:

```php
$refund = CreateRefundData::create(
    orderUuid: $uuid,
    amount: 10.00,
);
```

### Enums

Native PHP 8.1 backed enums are available for environments, payment methods, and payment statuses. Setters accept both enums and strings.

## No Changes Needed

The following work exactly as before:
- Fluent struct builders (`new OrderData()` + setters)
- Array hydration (`new OrderData([...])`)
- Array responses from all client methods
- Factory methods (`$client->orders()`, `$client->shipping()`, etc.)
- Webhook token decoding (`$client->decodeToken()`)
