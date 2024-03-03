<?php

namespace App\Services\update;

use App\Contracts\IVehicleRepository;
use App\DTO\VehicleDTO;
use App\Exceptions\BusinessException;
use App\Models\Vehicle;
use App\Repositories\VehicleRepository;

class UpdateVehicleService
{
    private IVehicleRepository $repository;

    public function __construct()
    {
        $this->repository = new VehicleRepository();
    }

    public function execute(VehicleDTO $vehicleDTO, Vehicle $vehicle): Vehicle
    {
        $vehicleWithNumber = $this->repository->getVehicleByCarNumber($vehicleDTO->getCarNumber());

        if ($vehicleWithNumber !== null) {
            throw new BusinessException('Транспорт с таким номером уже существует.');
        } else if ($vehicle->car_number !== $vehicleDTO->getCarNumber()) {
            return $this->repository->updateVehicle($vehicleDTO, $vehicle);
        }
    }
}
