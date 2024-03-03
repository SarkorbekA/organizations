<?php

namespace App\Services\update;

use App\Contracts\IFuelSensorRepository;
use App\DTO\FuelSensorDTO;
use App\Exceptions\BusinessException;
use App\Models\FuelSensor;
use App\Repositories\FuelSensorRepository;

class UpdateFuelSensorService
{
    private IFuelSensorRepository $repository;

    public function __construct()
    {
        $this->repository = new FuelSensorRepository();
    }

    public function execute(FuelSensorDTO $fuelSensorDTO, FuelSensor $fuelSensor): FuelSensor
    {
        $fuelSensorWithName = $this->repository->getFuelSensorByName($fuelSensorDTO->getName());

//        dd($fuelSensorDTO->getName());
//        dd($fuelSensorWithName->name);
//        dd($fuelSensor->name);

//        || $fuelSensor->name === $fuelSensorDTO->getName()

//    else if ($fuelSensor->name === $fuelSensorDTO->getName()) {
//        return $this->repository->updateFuelSensor($fuelSensorDTO, $fuelSensor);
//    }

//        if ($fuelSensor->name !== $fuelSensorDTO->getName())

        if ($fuelSensorWithName !== null && $fuelSensor->name !== $fuelSensorDTO->getName()) {
            throw new BusinessException('Сенсор топлива с таким названием уже существует.');
        } else {
            return $this->repository->updateFuelSensor($fuelSensorDTO, $fuelSensor);
        }
    }
}
