<?php

namespace App\Services\create;

use App\Contracts\IFuelSensorRepository;
use App\DTO\FuelSensorDTO;
use App\Exceptions\BusinessException;
use App\Models\FuelSensor;
use App\Repositories\FuelSensorRepository;

class CreateFuelSensorService
{
    private IFuelSensorRepository $repository;
    public function __construct()
    {
        $this->repository = new FuelSensorRepository();
    }

    public function execute(FuelSensorDTO $fuelSensorDTO): FuelSensor
    {
        $fuelSensorWithName = $this->repository->getFuelSensorByName($fuelSensorDTO->getName());
        if ($fuelSensorWithName !== null) {
            throw new BusinessException('Сенсор с таким названием уже существует.');
        }

        return $this->repository->createFuelSensor($fuelSensorDTO);
    }
}
