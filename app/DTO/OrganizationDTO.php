<?php

namespace App\DTO;

class OrganizationDTO
{
    public function __construct(
        private string $name,
        private string $country,
        private string $address
    )
    {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function getAddress(): string
    {
        return $this->address;
    }



    public static function fromArray(array $data): static
    {
        return new static(
            name: $data['name'],
            country: $data['country'],
            address: $data['address']
        );
    }

}
