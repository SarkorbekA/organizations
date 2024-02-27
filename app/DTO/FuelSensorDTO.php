<?php

namespace App\DTO;

class FuelSensorDTO
{

    public function __construct(
        private string $name,
        private string $fuel_level,
        private string $status,
        private string $vehicle_id
    )
    {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getFuelLevel(): int
    {
        return $this->fuel_level;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getVehicleId(): int
    {
        return $this->vehicle_id;
    }



    public static function fromArray(array $data): static
    {
        return new static(
            name: $data['name'],
            fuel_level: $data['fuel_level'],
            status: $data['status'],
            vehicle_id: $data['vehicle_id']
        );
    }
}
