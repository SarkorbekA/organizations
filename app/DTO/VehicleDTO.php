<?php

namespace App\DTO;

class VehicleDTO
{
    public function __construct(
        private string $model,
        private string $color,
        private int    $year,
        private string $car_number,
        private int    $organization_id,
    )
    {

    }

    public function getModel(): string
    {
        return $this->model;
    }

    public function getColor(): string
    {
        return $this->color;
    }

    public function getYear(): int
    {
        return $this->year;
    }

    public function getCarNumber(): string
    {
        return $this->car_number;
    }

    public function getOrganizationId(): int
    {
        return $this->organization_id;
    }


    public static function fromArray(array $data): static
    {
        return new static(
            model: $data['model'],
            color: $data['color'],
            year: $data['year'],
            car_number: $data['car_number'],
            organization_id: $data['organization_id']
        );
    }
}
