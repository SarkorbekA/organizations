<?php

namespace App\Repositories;

use App\Contracts\IVehicleRepository;
use App\DTO\VehicleDTO;
use App\Models\Vehicle;

class VehicleRepository implements IVehicleRepository
{
    public function getVehicleById(int $vehicleId): ?Vehicle
    {
        /** @var Vehicle|null $vehicle */
        $vehicle = Vehicle::query()->find($vehicleId);
        return $vehicle;
    }

    public function createVehicle(VehicleDTO $vehicleDTO): Vehicle
    {
        $vehicle = new Vehicle();
        $vehicle->model = $vehicleDTO->getModel();
        $vehicle->color = $vehicleDTO->getColor();
        $vehicle->year = $vehicleDTO->getYear();
        $vehicle->car_number = $vehicleDTO->getCarNumber();
        $vehicle->organization_id = $vehicleDTO->getOrganizationId();
        $vehicle->save();

        return $vehicle;
    }

    public function getVehicleByCarNumber(string $carNumber): ?Vehicle
    {
        /** @var Vehicle|null $vehicle */
        $vehicle = Vehicle::query()->where('car_number', $carNumber)->first();

        return $vehicle;
    }
}
