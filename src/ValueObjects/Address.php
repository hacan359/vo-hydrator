<?php

declare(strict_types=1);

namespace App\ValueObjects;

final class Address
{
    private ?string $country;
    private ?string $countryCode;
    private ?string $region;
    private ?string $city;
    private ?string $addressLine;
    private ?string $addressLineSecond;
    private ?string $postCode;
    private ?string $full;

    public function __construct(
        ?string $full = null,
        ?string $countryCode = null,
        ?string $country = null,
        ?string $region = null,
        ?string $city = null,
        ?string $postCode = null,
        ?string $addressLine = null,
        ?string $addressLineSecond = null
    ) {
        if (is_string($country)) {
            $country = trim($country);
        }
        if (is_string($countryCode)) {
            $countryCode = trim($countryCode);
        }
        if (is_string($region)) {
            $region = trim($region);
        }
        if (is_string($city)) {
            $city = trim($city);
        }
        if (is_string($addressLine)) {
            $addressLine = trim($addressLine);
        }
        if (is_string($addressLineSecond)) {
            $addressLineSecond = trim($addressLineSecond);
        }
        if (is_string($postCode)) {
            $postCode = trim($postCode);
        }
        $this->country = $country ?: null;
        $this->countryCode = $countryCode ?: null;
        $this->region = $region ?: null;
        $this->city = $city ?: null;
        $this->addressLine = $addressLine ?: null;
        $this->addressLineSecond = $addressLineSecond ?: null;
        $this->postCode = $postCode ?: null;

        $address = [
            $this->country,
            $this->region,
            $this->city,
            $this->postCode,
            $this->addressLine,
            $this->addressLineSecond,
        ];
        $hasAddress = (bool)array_filter($address, static fn($value) => $value !== null);
        $this->full = $full ?? ($hasAddress ? implode(', ', $address) : null);
    }

    public function isNull(): bool
    {
        return $this->full === null;
    }

    public function getFull(): ?string
    {
        return $this->full;
    }

    /**
     * @param string|null $full
     *
     * @return $this
     */
    public function setFull(?string $full): self
    {
        $this->full = $full;

        return $this;
    }

    public function getClearedFull(): ?string
    {
        return implode(
            ', ',
            array_filter(
                array_map('trim', explode(',', $this->full ?: '')),
                static fn($value) => !empty($value)
            )
        ) ?: null;
    }

    public function getCountryCode(): ?string
    {
        return $this->countryCode;
    }

    public function setCountryCode($countryCode): self
    {
        $this->countryCode = $countryCode;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCountry(): ?string
    {
        return $this->country;
    }

    /**
     * @param string|null $country
     *
     * @return $this
     */
    public function setCountry(?string $country): self
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getRegion(): ?string
    {
        return $this->region;
    }

    /**
     * @param string|null $region
     *
     * @return $this
     */
    public function setRegion(?string $region): self
    {
        $this->region = $region;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @param string|null $city
     *
     * @return $this
     */
    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPostCode(): ?string
    {
        return $this->postCode;
    }

    /**
     * @param string|null $postCode
     *
     * @return $this
     */
    public function setPostCode(?string $postCode): self
    {
        $this->postCode = $postCode;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getAddressLine(): ?string
    {
        return $this->addressLine;
    }

    /**
     * @param string|null $addressLine
     *
     * @return $this
     */
    public function setAddressLine(?string $addressLine): self
    {
        $this->addressLine = $addressLine;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getAddressLineSecond(): ?string
    {
        return $this->addressLineSecond;
    }

    /**
     * @param string|null $addressLineSecond
     *
     * @return $this
     */
    public function setAddressLineSecond(?string $addressLineSecond): self
    {
        $this->addressLineSecond = $addressLineSecond;

        return $this;
    }
}
