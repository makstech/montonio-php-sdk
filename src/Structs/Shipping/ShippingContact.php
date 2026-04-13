<?php

declare(strict_types=1);

namespace Montonio\Structs\Shipping;

use Montonio\Structs\AbstractStruct;

class ShippingContact extends AbstractStruct
{
    protected string $name;
    protected string $phoneCountryCode;
    protected string $phoneNumber;
    protected string $firstName;
    protected string $lastName;
    protected string $streetAddress;
    protected string $locality;
    protected string $postalCode;
    protected string $country;
    protected string $region;
    protected string $email;
    protected string $companyName;

    public function getName(): ?string
    {
        return $this->name ?? null;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPhoneCountryCode(): ?string
    {
        return $this->phoneCountryCode ?? null;
    }

    public function setPhoneCountryCode(string $phoneCountryCode): self
    {
        $this->phoneCountryCode = $phoneCountryCode;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber ?? null;
    }

    public function setPhoneNumber(string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName ?? null;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName ?? null;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getStreetAddress(): ?string
    {
        return $this->streetAddress ?? null;
    }

    public function setStreetAddress(string $streetAddress): self
    {
        $this->streetAddress = $streetAddress;

        return $this;
    }

    public function getLocality(): ?string
    {
        return $this->locality ?? null;
    }

    public function setLocality(string $locality): self
    {
        $this->locality = $locality;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode ?? null;
    }

    public function setPostalCode(string $postalCode): self
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country ?? null;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getRegion(): ?string
    {
        return $this->region ?? null;
    }

    public function setRegion(string $region): self
    {
        $this->region = $region;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email ?? null;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getCompanyName(): ?string
    {
        return $this->companyName ?? null;
    }

    public function setCompanyName(string $companyName): self
    {
        $this->companyName = $companyName;

        return $this;
    }
}
