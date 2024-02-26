<?php

namespace App\DTO;

class OrganizationDTO
{
    public function __construct(
        private string $name
    )
    {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public static function fromArray(array $data): static
    {
        return new static(
            name: $data['name'],
        );
    }

}
