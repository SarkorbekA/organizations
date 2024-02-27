<?php

namespace App\Repositories;

use App\Contracts\IFuelSensorRepository;
use App\DTO\FuelSensorDTO;
use App\Models\FuelSensor;

class FuelSensorRepository implements IFuelSensorRepository
{
    public function getFuelSensorById(int $fuelSensorId): ?FuelSensor
    {
        /** @var FuelSensor|null $fuel_sensor */
        $fuel_sensor = FuelSensor::query()->find($fuelSensorId);
        return $fuel_sensor;
    }

    public function createFuelSensor(FuelSensorDTO $fuelSensorDTO): FuelSensor
    {
        $fuel_sensor = new FuelSensor();
        $fuel_sensor->name = $fuelSensorDTO->getName();
        $fuel_sensor->fuel_level = $fuelSensorDTO->getFuelLevel();
        $fuel_sensor->status = $fuelSensorDTO->getStatus();
        $fuel_sensor->vehicle_id = $fuelSensorDTO->getVehicleId();
        $fuel_sensor->save();

        return $fuel_sensor;
    }

    public function getFuelSensorByName(string $name): ?FuelSensor
    {
        /** @var FuelSensor|null $fuel_sensor */
        $fuel_sensor = FuelSensor::query()->where('name', $name)->first();

        return $fuel_sensor;
    }
}
