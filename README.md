# PHP library for Montonio API

[![Latest Version](https://img.shields.io/github/release/makstech/montonio-php-sdk.svg?style=flat-square)](https://github.com/makstech/montonio-php-sdk/releases)
[![Total Downloads](https://img.shields.io/packagist/dt/makstech/montonio-php-sdk?style=flat-square&label=downloads)](https://packagist.org/packages/makstech/montonio-php-sdk)
[![Codecov](https://img.shields.io/codecov/c/github/makstech/montonio-php-sdk?style=flat-square)](https://app.codecov.io/gh/makstech/montonio-php-sdk)

PHP SDK for Montonio Payments based on [https://docs.montonio.com](https://docs.montonio.com).
- Allows to fluently create requests with structures.
- Or a raw data can be passed to the structure object, to have it create all the child structures.
- Uses cURL to make requests.

## Requirements

PHP 8.0 or later.

## Composer

You can install the SDK via Composer. Run the following command:
```shell
composer require makstech/montonio-php-sdk
```

## Usage

You can find your API keys by going to your Montonio dashboard → [_Stores_](https://partnerv2.montonio.com/stores)
→ Choose the store you are integrating → _Go to API keys_.

To use the SDK, start by initializing the `Montonio\MontonioClient` using your access and secret keys.
And from there, you can fluently get the "sub-clients". For example, to get `OrdersClient` and create an order:

```php
use Montonio\MontonioClient;

// Initialize the client
$client = new MontonioClient(
    $accessKey,
    $secretKey,
    MontonioClient::ENVIRONMENT_SANDBOX, // or MontonioClient::ENVIRONMENT_LIVE
);
 
// Get OrdersClient
$ordersClient = $client->orders();

// Create order structure

// This example shows only some setters and options. Check source
// structures for all options and check documentation for required fields.
// https://docs.montonio.com/api/stargate/guides/orders#complete-example

$address = (new \Montonio\Structs\Address([
        'firstName' => 'elon',
        'lastName' => 'musk',
    ]))
    // or
    ->setFirstName('jeff')
    ->setLastName('bezos')
    ...;

// This is same...
$orderData = new \Montonio\Structs\OrderData([
    'locale' => 'en',
    ...
    'billingAddress' => [
        'firstName' => 'jeff',
        ...
    ],
]);

// ... as this, but fluently
$orderData
    ->setLocale('en')
    ->setBillingAddress($address)
    ->setMerchantReference(uniqid())
    ->setReturnUrl('https://google.com?q=montonio+return+url')
    ->setNotificationUrl('https://google.com?q=montonio+notification')
    ->setGrandTotal(1337)
    ->setCurrency('EUR')
    ->setPayment(
        $payment = (new \Montonio\Structs\Payment())
            ->setCurrency('EUR')
            ->setAmount(1337)
            ->setMethod(Payment::METHOD_PAYMENT_INITIATION)
    )
    ->addLineItem(
        $item1 = (new \Montonio\Structs\LineItem())
            ->setName('elephant')
            ->setFinalPrice(668.5)
            ->setQuantity(2)
    )
    ->setShippingAddress($address)
;

// Send API request
$order = $ordersClient->createOrder($orderData);

// Get payment URL
$paymentUrl = $order['paymentUrl'];

// Redirect customer to that URL
header("Location: $paymentUrl");
```

You can find the documentation with the response data example, in the [official docs](https://docs.montonio.com/api/stargate/guides/orders#4-submitting-the-token).

## License

This library is made available under the MIT License (MIT). Please see [License File](LICENSE) for more information.
