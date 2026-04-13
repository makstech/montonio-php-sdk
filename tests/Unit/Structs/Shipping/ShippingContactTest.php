<?php

declare(strict_types=1);

namespace Tests\Unit\Structs\Shipping;

use Montonio\Structs\Shipping\ShippingContact;
use Tests\BaseTestCase;

class ShippingContactTest extends BaseTestCase
{
    public function testFluentSetters(): void
    {
        $contact = (new ShippingContact())
            ->setName('Receiver X')
            ->setPhoneCountryCode('372')
            ->setPhoneNumber('53334770')
            ->setFirstName('John')
            ->setLastName('Doe')
            ->setStreetAddress('Kai 1')
            ->setLocality('Tallinn')
            ->setPostalCode('10111')
            ->setCountry('EE')
            ->setRegion('Harjumaa')
            ->setEmail('john@example.com')
            ->setCompanyName('Acme Corp');

        $this->assertSame('Receiver X', $contact->getName());
        $this->assertSame('372', $contact->getPhoneCountryCode());
        $this->assertSame('53334770', $contact->getPhoneNumber());
        $this->assertSame('John', $contact->getFirstName());
        $this->assertSame('Doe', $contact->getLastName());
        $this->assertSame('Kai 1', $contact->getStreetAddress());
        $this->assertSame('Tallinn', $contact->getLocality());
        $this->assertSame('10111', $contact->getPostalCode());
        $this->assertSame('EE', $contact->getCountry());
        $this->assertSame('Harjumaa', $contact->getRegion());
        $this->assertSame('john@example.com', $contact->getEmail());
        $this->assertSame('Acme Corp', $contact->getCompanyName());
    }

    public function testConstructFromArray(): void
    {
        $contact = new ShippingContact([
            'name' => 'Sender Y',
            'phoneCountryCode' => '370',
            'phoneNumber' => '12345678',
            'streetAddress' => 'Main St 5',
        ]);

        $this->assertSame('Sender Y', $contact->getName());
        $this->assertSame('370', $contact->getPhoneCountryCode());
        $this->assertSame('Main St 5', $contact->getStreetAddress());
    }

    public function testToArray(): void
    {
        $contact = (new ShippingContact())
            ->setName('Test')
            ->setPhoneCountryCode('372')
            ->setPhoneNumber('555');

        $array = $contact->toArray();

        $this->assertSame('Test', $array['name']);
        $this->assertSame('372', $array['phoneCountryCode']);
        $this->assertSame('555', $array['phoneNumber']);
    }

    public function testNullableGetters(): void
    {
        $contact = new ShippingContact();

        $this->assertNull($contact->getName());
        $this->assertNull($contact->getFirstName());
        $this->assertNull($contact->getEmail());
    }
}
