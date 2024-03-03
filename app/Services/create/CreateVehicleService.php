<?php

namespace App\Services\create;

use App\Contracts\IVehicleRepository;
use App\DTO\VehicleDTO;
use App\Exceptions\BusinessException;
use App\Models\Vehicle;
use App\Repositories\VehicleRepository;

class CreateVehicleService
{
    private IVehicleRepository $repository;

    public function __construct()
    {
        $this->repository = new VehicleRepository();
    }

    public function execute(VehicleDTO $vehicleDTO): Vehicle
    {
        $vehicleWithNumber = $this->repository->getVehicleByCarNumber($vehicleDTO->getCarNumber());
        if ($vehicleWithNumber !== null) {
            throw new BusinessException('Транспорт с таким номером уже существует.');
        }

        return $this->repository->createVehicle($vehicleDTO);
    }
}
