<?php

namespace App\Contracts;

use App\DTO\VehicleDTO;
use App\Models\Vehicle;

interface IVehicleRepository
{
    public function getVehicleById(int $vehicleId): ?Vehicle;

    public function getVehicleByCarNumber(string $carNumber): ?Vehicle;

    public function createVehicle(VehicleDTO $vehicleDTO): ?Vehicle;
    public function updateVehicle(VehicleDTO $vehicleDTO, Vehicle $vehicle): ?Vehicle;
}
