<?php

namespace App\Http\Controllers;

use App\Contracts\IVehicleRepository;
use App\DTO\VehicleDTO;
use App\Exceptions\BusinessException;
use App\Http\Requests\VehicleRequest;
use App\Http\Resources\FuelSensorResource;
use App\Http\Resources\VehicleResource;
use App\Models\Vehicle;
use App\Repositories\VehicleRepository;
use App\Services\CreateVehicleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class VehicleController extends Controller
{
    private IVehicleRepository $repository;

    public function __construct()
    {
        $this->repository = new VehicleRepository();
    }

    /**
     * Display a listing of the resource.
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $vehicles = cache()->remember('vehicles', 120, function () {
            return Vehicle::all();
        });

        return response()->json([
            'data' => $vehicles
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     * @param VehicleRequest $request
     * @return VehicleResource
     * @throws BusinessException
     */
    public function store(VehicleRequest $request, CreateVehicleService $service): VehicleResource
    {
        $validated = $request->validated();

        $vehicle = $service->execute(VehicleDTO::fromArray($validated));

        return new VehicleResource($vehicle);
    }

    /**
     * Display the specified resource.
     * @param Vehicle $vehicle
     * @return VehicleResource
     */
    public function show(string $id): VehicleResource|JsonResponse
    {
        $vehicle = $this->repository->getVehicleById($id);

        if ($vehicle === null) {
            return response()->json([
                'message' => 'Транспорт не найден!'
            ], 400);
        }
        return new VehicleResource($vehicle);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * @param VehicleRequest $request
     * @param Vehicle $vehicle
     * @return VehicleResource
     */
    public function update(VehicleRequest $request, int $id)
    {
        $validated = $request->validated();

        Vehicle::query()->find($id)->update(
            $validated
        );

        $vehicle = $this->repository->getVehicleById($id);

        return new VehicleResource($vehicle);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        $vehicle = $this->repository->getVehicleById($id);
        $result = null;

        if ($vehicle === null) {
            $result = response()->json([
                'message' => 'Такой записи не существует'
            ], 400);
        } else {
            Vehicle::query()->find($id)->delete();
            $result = response()->json([
                'message' => 'Запись была успешна удалена'
            ]);
        }

        return $result;
    }



    /**
     * @param int $vehicle_id
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function getVehicleFuelSensors(
        int $vehicle_id
    ): JsonResponse|AnonymousResourceCollection
    {
        /** @var Vehicle|null $vehicle */
        $vehicle = Vehicle::query()->find($vehicle_id);


        if ($vehicle === null) {
            return response()->json([
                'message' => 'Транспорт не найден!'
            ], 400);
        }

        $fuel_sensors = $vehicle->fuel_sensor()->get();


        return FuelSensorResource::collection($fuel_sensors);
    }

    public function getVehicleFuelSensorsById(
        int $vehicle_id,
        int $fuel_sensor_id,
    ): JsonResponse|FuelSensorResource
    {
        /** @var Vehicle|null $vehicle */
        $vehicle = Vehicle::query()->find($vehicle_id);

        if ($vehicle === null) {
            return response()->json([
                'message' => 'Транспорт не найден!'
            ], 400);
        }

        $fuel_sensor = $vehicle->fuel_sensor()->find($fuel_sensor_id);


        if ($fuel_sensor === null) {
            return response()->json([
                'message' => 'Сенсор топлива не найден!'
            ], 400);
        }

        return new FuelSensorResource($fuel_sensor);
    }
}
