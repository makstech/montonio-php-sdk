<?php

declare(strict_types=1);

namespace Tests\Unit\Structs\Shipping;

use Montonio\Structs\Shipping\ShipmentProduct;
use Tests\BaseTestCase;

class ShipmentProductTest extends BaseTestCase
{
    public function testFluentSetters(): void
    {
        $product = (new ShipmentProduct())
            ->setSku('product-123')
            ->setName('Blue Police Car')
            ->setQuantity(3)
            ->setBarcode('0123456789123')
            ->setPrice(19.99)
            ->setCurrency('EUR')
            ->setAttributes(['color' => 'Blue'])
            ->setImageUrl('https://example.com/image.jpg')
            ->setStoreProductUrl('https://example.com/product')
            ->setDescription('A blue toy car');

        $this->assertSame('product-123', $product->getSku());
        $this->assertSame('Blue Police Car', $product->getName());
        $this->assertSame(3.0, $product->getQuantity());
        $this->assertSame('0123456789123', $product->getBarcode());
        $this->assertSame(19.99, $product->getPrice());
        $this->assertSame('EUR', $product->getCurrency());
        $this->assertSame(['color' => 'Blue'], $product->getAttributes());
        $this->assertSame('https://example.com/image.jpg', $product->getImageUrl());
        $this->assertSame('https://example.com/product', $product->getStoreProductUrl());
        $this->assertSame('A blue toy car', $product->getDescription());
    }

    public function testConstructFromArray(): void
    {
        $product = new ShipmentProduct([
            'sku' => 'sku-1',
            'name' => 'Widget',
            'quantity' => 5,
        ]);

        $this->assertSame('sku-1', $product->getSku());
        $this->assertSame('Widget', $product->getName());
        $this->assertSame(5.0, $product->getQuantity());
    }

    public function testToArray(): void
    {
        $product = (new ShipmentProduct())
            ->setSku('sku-1')
            ->setName('Item')
            ->setQuantity(1);

        $array = $product->toArray();

        $this->assertSame('sku-1', $array['sku']);
        $this->assertSame('Item', $array['name']);
    }

    public function testNullableGetters(): void
    {
        $product = new ShipmentProduct();

        $this->assertNull($product->getSku());
        $this->assertNull($product->getBarcode());
        $this->assertNull($product->getPrice());
        $this->assertNull($product->getDescription());
    }
}
