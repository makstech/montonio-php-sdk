# Montonio PHP SDK

[![Latest Version](https://img.shields.io/github/release/makstech/montonio-php-sdk.svg?style=flat-square)](https://github.com/makstech/montonio-php-sdk/releases)
[![Total Downloads](https://img.shields.io/packagist/dt/makstech/montonio-php-sdk?style=flat-square&label=downloads)](https://packagist.org/packages/makstech/montonio-php-sdk)
[![Codecov](https://img.shields.io/codecov/c/github/makstech/montonio-php-sdk?style=flat-square)](https://app.codecov.io/gh/makstech/montonio-php-sdk)

PHP SDK for the [Montonio Stargate API](https://docs.montonio.com/api/stargate/) and [Shipping V2 API](https://docs.montonio.com/api/shipping-v2/reference). Wraps both APIs with fluent struct builders and JWT-authenticated requests.

## Features

- **Full API coverage** — Payments (Stargate) and Shipping V2 APIs
- **PSR-18 support** — bring your own HTTP client (Guzzle, Symfony, etc.) or use the built-in cURL transport
- **Fluent struct builders** — build request payloads with chained setters, array hydration, or `static create()` with named parameters
- **Typed enums** — `Environment`, `PaymentMethod`, `PaymentStatus` backed enums with full IDE support
- **Granular exceptions** — `AuthenticationException`, `ValidationException`, `NotFoundException`, `RateLimitException`, `ServerException`
- **JWT authentication** — token generation, webhook signature verification

### API Coverage

| Client | Methods | API Docs |
|--------|---------|----------|
| **Orders** | `createOrder`, `getOrder` | [Orders guide](https://docs.montonio.com/api/stargate/guides/orders) |
| **Payment Links** | `createPaymentLink`, `getPaymentLink` | [Payment links guide](https://docs.montonio.com/api/stargate/guides/payment-links) |
| **Payment Intents** | `createDraft` | [Embedded cards guide](https://docs.montonio.com/api/stargate/guides/embedded-cards) |
| **Refunds** | `createRefund` | [Refunds guide](https://docs.montonio.com/api/stargate/guides/refunds) |
| **Sessions** | `createSession` | [Embedded cards guide](https://docs.montonio.com/api/stargate/guides/embedded-cards) |
| **Payouts** | `getPayouts`, `exportPayout`, `getBalances` | [Payouts guide](https://docs.montonio.com/api/stargate/guides/payouts) |
| **Stores** | `getPaymentMethods` | [Payment methods guide](https://docs.montonio.com/api/stargate/guides/payment-methods) |
| **Shipping / Carriers** | `getCarriers` | [Shipping API reference](https://docs.montonio.com/api/shipping-v2/reference) |
| **Shipping / Methods** | `getShippingMethods`, `getPickupPoints`, `getCourierServices`, `filterByParcels`, `getRates` | [Shipping methods guide](https://docs.montonio.com/api/shipping-v2/guides/shipping-methods) |
| **Shipping / Shipments** | `createShipment`, `updateShipment`, `getShipment` | [Shipments guide](https://docs.montonio.com/api/shipping-v2/guides/shipments) |
| **Shipping / Labels** | `createLabelFile`, `getLabelFile` | [Labels guide](https://docs.montonio.com/api/shipping-v2/guides/labels) |
| **Shipping / Webhooks** | `createWebhook`, `listWebhooks`, `deleteWebhook` | [Webhooks guide](https://docs.montonio.com/api/shipping-v2/guides/webhooks) |

Supported payment methods: bank payments, card payments (Apple Pay, Google Pay), BLIK, Buy Now Pay Later, and Hire Purchase.

## Requirements

- PHP 8.2 or later
- cURL extension (or a PSR-18 HTTP client)

> **Using PHP 8.0 or 8.1?** [v1 (1.x branch)](https://github.com/makstech/montonio-php-sdk/tree/1.x) is actively maintained with full API coverage (Payments + Shipping):
> ```shell
> composer require makstech/montonio-php-sdk:^1.0
> ```

## Installation

```shell
composer require makstech/montonio-php-sdk
```

## Getting Started

Get your API keys from the Montonio [Partner System](https://partnerv2.montonio.com/stores) (Stores → your store → API keys).

```php
use Montonio\MontonioClient;

$client = new MontonioClient(
    $accessKey,
    $secretKey,
    MontonioClient::ENVIRONMENT_SANDBOX, // or ENVIRONMENT_LIVE
);
```

All sub-clients are accessed via factory methods on the main client (e.g. `$client->orders()`, `$client->refunds()`).

## Custom HTTP Client (PSR-18)

By default, the SDK uses cURL for HTTP requests. You can optionally provide your own PSR-18 HTTP client:

```php
use Montonio\MontonioClient;

$httpFactory = new \Nyholm\Psr7\Factory\Psr17Factory();

$client = new MontonioClient(
    $accessKey,
    $secretKey,
    MontonioClient::ENVIRONMENT_SANDBOX,
    httpClient: new \GuzzleHttp\Client(),
    requestFactory: $httpFactory,
    streamFactory: $httpFactory,
);
```

This is useful for testing (inject a mock client) or when your framework already provides an HTTP client.

## Orders

Create a payment order and redirect the customer to the payment URL.

Structs can be built fluently or from arrays — both approaches can be mixed:

```php
$orderData = (new \Montonio\Structs\OrderData())
    ->setMerchantReference('ORDER-123')
    ->setReturnUrl('https://myshop.com/return')
    ->setNotificationUrl('https://myshop.com/webhook')
    ->setGrandTotal(29.99)
    ->setCurrency('EUR')
    ->setLocale('en')
    ->setPayment(
        (new \Montonio\Structs\Payment())
            ->setMethod(\Montonio\Structs\Payment::METHOD_PAYMENT_INITIATION)
            ->setAmount(29.99)
            ->setCurrency('EUR')
    )
    ->setLineItems([
        [
            'name' => 'T-Shirt',
            'quantity' => 1,
            'finalPrice' => 19.99,
        ],
    ])
    ->addLineItem(
        (new \Montonio\Structs\LineItem())
            ->setName('Socks')
            ->setQuantity(2)
            ->setFinalPrice(5.00)
    )
    ->setBillingAddress(new \Montonio\Structs\Address([
        'firstName' => 'John',
        'lastName' => 'Doe',
        'email' => 'john@example.com',
        'addressLine1' => 'Main St 1',
        'locality' => 'Tallinn',
        'country' => 'EE',
    ]));

$order = $client->orders()->createOrder($orderData);

// Redirect customer to payment
header('Location: ' . $order['paymentUrl']);
```

Retrieve an order:

```php
$order = $client->orders()->getOrder($orderUuid);
echo $order['paymentStatus']; // 'PAID', 'PENDING', etc.
```

See the [orders guide](https://docs.montonio.com/api/stargate/guides/orders) for all available fields and response details.

## Payment Methods

Fetch available payment methods for your store:

```php
$methods = $client->stores()->getPaymentMethods();
```

## Payment Links

Create shareable payment links without building a full checkout:

```php
$link = $client->paymentLinks()->createPaymentLink(
    (new \Montonio\Structs\CreatePaymentLinkData())
        ->setDescription('Invoice #456')
        ->setCurrency('EUR')
        ->setAmount(50.00)
        ->setLocale('en')
        ->setAskAdditionalInfo(true)
        ->setExpiresAt(date('c', strtotime('+7 days')))
        ->setType('one_time')
        ->setNotificationUrl('https://myshop.com/webhook')
);

echo $link['url']; // https://pay.montonio.com/...
```

Retrieve a payment link:

```php
$link = $client->paymentLinks()->getPaymentLink($linkUuid);
```

## Refunds

Issue a full or partial refund for a paid order:

```php
$refund = $client->refunds()->createRefund(
    (new \Montonio\Structs\CreateRefundData())
        ->setOrderUuid($orderUuid)
        ->setAmount(10.00)
        ->setIdempotencyKey($uniqueKey) // V4 UUID recommended
);

echo $refund['status']; // 'PENDING'
```

## Webhooks

Montonio sends webhook notifications to your `notificationUrl` when order or refund statuses change. Use `decodeToken()` to verify the JWT signature and decode the payload:

```php
// Order webhook: {"orderToken": "<jwt>"}
$decoded = $client->decodeToken($requestBody['orderToken']);
echo $decoded->paymentStatus; // 'PAID', 'PENDING', 'ABANDONED', etc.
echo $decoded->merchantReference;

// Refund webhook: {"refundToken": "<jwt>"}
$decoded = $client->decodeToken($requestBody['refundToken']);
echo $decoded->refundStatus; // 'SUCCESSFUL', 'PENDING', 'REJECTED', etc.
```

See the [webhooks guide](https://docs.montonio.com/api/stargate/guides/webhooks) for full payload details and retry policy.

## Embedded Payments

### Embedded Card Payments

For embedding card payment fields directly in your checkout, create a session and pass it to the [MontonioCheckout JS SDK](https://docs.montonio.com/api/stargate/guides/embedded-cards/):

```php
$session = $client->sessions()->createSession();
$sessionUuid = $session['uuid']; // Pass to frontend JS SDK
```

### Embedded BLIK

For embedded BLIK payments, pass the customer's 6-digit BLIK code when creating an order:

```php
$orderData = (new \Montonio\Structs\OrderData())
    ->setPayment(
        (new \Montonio\Structs\Payment())
            ->setMethod(\Montonio\Structs\Payment::METHOD_BLIK)
            ->setAmount(100.00)
            ->setCurrency('PLN')
            ->setMethodOptions(
                (new \Montonio\Structs\PaymentMethodOptions())
                    ->setBlikCode('777123')
            )
    )
    // ... other order fields
;
```

See the [embedded BLIK guide](https://docs.montonio.com/api/stargate/guides/embedded-blik/) for the full flow.

## Payouts

Retrieve payout reports and balances:

```php
// Get store balances
$balances = $client->payouts()->getBalances();

// List payouts for a store
$payouts = $client->payouts()->getPayouts($storeUuid, limit: 50, offset: 0, order: 'DESC');

// Export a payout report (excel or xml)
$export = $client->payouts()->exportPayout($storeUuid, $payoutUuid, 'excel');
$downloadUrl = $export['url'];
```

## Shipping

All shipping sub-clients are accessed via `$client->shipping()`:

### Carriers

```php
$carriers = $client->shipping()->carriers()->getCarriers();
```

### Shipping Methods

```php
// All shipping methods
$methods = $client->shipping()->shippingMethods()->getShippingMethods();

// Pickup points for a carrier
$pickupPoints = $client->shipping()->shippingMethods()
    ->getPickupPoints('omniva', 'EE');

// Courier services for a carrier
$courierServices = $client->shipping()->shippingMethods()
    ->getCourierServices('dpd', 'EE');

// Filter methods by parcel dimensions
$filtered = $client->shipping()->shippingMethods()->filterByParcels(
    (new \Montonio\Structs\Shipping\FilterByParcelsData())
        ->setParcels([
            (new \Montonio\Structs\Shipping\ShipmentParcel())->setWeight(1.5),
        ]),
    'EE' // destination
);

// Calculate shipping rates
$rates = $client->shipping()->shippingMethods()->getRates(
    (new \Montonio\Structs\Shipping\ShippingRatesData())
        ->setDestination('EE')
        ->setParcels([
            (new \Montonio\Structs\Shipping\RatesParcel())->setItems([
                (new \Montonio\Structs\Shipping\RatesItem())
                    ->setLength(20.0)
                    ->setWidth(15.0)
                    ->setHeight(10.0)
                    ->setWeight(0.5),
            ]),
        ])
);
```

### Shipments

```php
$shipment = $client->shipping()->shipments()->createShipment(
    (new \Montonio\Structs\Shipping\CreateShipmentData())
        ->setShippingMethod(
            (new \Montonio\Structs\Shipping\ShipmentShippingMethod())
                ->setType('pickupPoint')
                ->setId($pickupPointId) // UUID from getPickupPoints()
        )
        ->setReceiver(
            (new \Montonio\Structs\Shipping\ShippingContact())
                ->setName('John Doe')
                ->setPhoneCountryCode('372')
                ->setPhoneNumber('53334770')
                ->setEmail('john@example.com')
        )
        ->setParcels([
            (new \Montonio\Structs\Shipping\ShipmentParcel())->setWeight(1.0),
        ])
        ->setMerchantReference('ORDER-123')
);

echo $shipment['id'];
echo $shipment['status']; // 'pending', 'registered', etc.

// Get shipment details
$shipment = $client->shipping()->shipments()->getShipment($shipmentId);

// Update a shipment
$updated = $client->shipping()->shipments()->updateShipment($shipmentId,
    (new \Montonio\Structs\Shipping\UpdateShipmentData())
        ->setReceiver(
            (new \Montonio\Structs\Shipping\ShippingContact())
                ->setName('Jane Doe')
                ->setPhoneCountryCode('372')
                ->setPhoneNumber('55512345')
        )
);
```

### Label Files

```php
$labelFile = $client->shipping()->labels()->createLabelFile(
    (new \Montonio\Structs\Shipping\CreateLabelFileData())
        ->setShipmentIds([$shipmentId])
        ->setPageSize('A4')
        ->setSynchronous(true)
);

echo $labelFile['labelFileUrl']; // PDF download URL (expires in 5 minutes)

// Get label file status
$labelFile = $client->shipping()->labels()->getLabelFile($labelFileId);
echo $labelFile['status']; // 'pending', 'ready', 'failed'
```

### Shipping Webhooks

```php
$webhook = $client->shipping()->webhooks()->createWebhook(
    (new \Montonio\Structs\Shipping\CreateShippingWebhookData())
        ->setUrl('https://myshop.com/shipping-webhook')
        ->setEnabledEvents([
            'shipment.registered',
            'shipment.statusUpdated',
            'labelFile.ready',
        ])
);

// List all webhooks
$webhooks = $client->shipping()->webhooks()->listWebhooks();

// Delete a webhook
$client->shipping()->webhooks()->deleteWebhook($webhookId);
```

See the [Shipping API reference](https://docs.montonio.com/api/shipping-v2/reference) for all available fields and response details.

## License

This library is made available under the MIT License (MIT). Please see [License File](LICENSE) for more information.
