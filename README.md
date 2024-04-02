# PHP library for Montonio API

PHP SDK for Montonio Payments based on [https://docs.montonio.com](https://docs.montonio.com)

## Requirements

PHP 8.0 or later

## Composer

You can install the SDK via Composer. Run the following command:
```shell
composer require makstech/montonio-php-sdk
```

## Usage

You can find your API keys by going to your [Montonio dashboard → _Stores_)](https://partnerv2.montonio.com/stores) → Choose the store you are integrating → _Go to API keys_.

To use the SDK, start by initializing `MontonioClient` using your access and secret keys. And from there, you can fluently get the "sub-clients". For example, to get `OrdersClient` and initialize order:

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

// This example shows all possible setters and options, you probably
// don't need it all, check documentation for required fields.
// https://docs.montonio.com/api/stargate/guides/orders#complete-example

$address = (new \Montonio\Structs\Address())
    ->setFirstName('jeff')
    ->setLastName('bezos')
    ->setEmail('jeff.bezon@amazon.com')
    ->setPhoneNumber('123456789')
    ->setPhoneCountry('1')
    ->setAddressLine1('amzn')
    ->setAddressLine2('1')
    ->setLocality('LA')
    ->setRegion('CA')
    ->setPostalCode('123')
    ->setCountry('US');

$orderData = new \Montonio\Structs\OrderData();
$orderData
    ->setLocale('en')
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
    ->setBillingAddress($address)
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
