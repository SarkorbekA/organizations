<?php

namespace App\Services;

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
        $organizationWithName = $this->repository->getVehicleByCarNumber($vehicleDTO->getCarNumber());
        if ($organizationWithName !== null) {
            throw new BusinessException('Транспорт с таким номером уже существует.');
        }

        return $this->repository->createVehicle($vehicleDTO);
    }
}
