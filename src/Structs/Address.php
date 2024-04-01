<?php

declare(strict_types=1);

namespace Montonio\Structs;

class Address extends AbstractStruct
{
    protected string $firstName;
    protected string $lastName;
    protected string $email;
    protected string $phoneNumber;
    protected string $phoneCountry;
    protected string $addressLine1;
    protected string $addressLine2;
    protected string $locality;
    protected string $region;
    protected string $postalCode;
    protected string $country;

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

    public function getEmail(): ?string
    {
        return $this->email ?? null;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

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

    public function getPhoneCountry(): ?string
    {
        return $this->phoneCountry ?? null;
    }

    public function setPhoneCountry(string $phoneCountry): self
    {
        $this->phoneCountry = $phoneCountry;

        return $this;
    }

    public function getAddressLine1(): ?string
    {
        return $this->addressLine1 ?? null;
    }

    public function setAddressLine1(string $addressLine1): self
    {
        $this->addressLine1 = $addressLine1;

        return $this;
    }

    public function getAddressLine2(): ?string
    {
        return $this->addressLine2 ?? null;
    }

    public function setAddressLine2(string $addressLine2): self
    {
        $this->addressLine2 = $addressLine2;

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

    public function getRegion(): ?string
    {
        return $this->region ?? null;
    }

    public function setRegion(string $region): self
    {
        $this->region = $region;

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
}
