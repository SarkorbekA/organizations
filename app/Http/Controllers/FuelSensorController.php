<?php

namespace App\Http\Controllers;

use App\Contracts\IFuelSensorRepository;
use App\DTO\FuelSensorDTO;
use App\Exceptions\BusinessException;
use App\Http\Requests\FuelSensorRequest;
use App\Http\Resources\FuelSensorResource;
use App\Models\FuelSensor;
use App\Repositories\FuelSensorRepository;
use App\Services\CreateFuelSensorService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FuelSensorController extends Controller
{
    private IFuelSensorRepository $repository;

    public function __construct()
    {
        $this->repository = new FuelSensorRepository();
    }

    /**
     * Display a listing of the resource.
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $fuel_sensors = cache()->remember('fuel_sensors', 120, function () {
            return FuelSensor::all();
        });

        return response()->json([
            'data' => $fuel_sensors
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
     * @param FuelSensorRequest $request
     * @return FuelSensorResource
     * @throws BusinessException
     */
    public function store(FuelSensorRequest $request, CreateFuelSensorService $service): FuelSensorResource
    {
        $validated = $request->validated();

        $vehicle = $service->execute(FuelSensorDTO::fromArray($validated));

        return new FuelSensorResource($vehicle);
    }

    /**
     * Display the specified resource.
     * @param FuelSensor $fuel_sensor
     * @return FuelSensorResource
     */
    public function show(string $id): FuelSensorResource|JsonResponse
    {
        $fuel_sensor = $this->repository->getFuelSensorById($id);

        if ($fuel_sensor === null) {
            return response()->json([
                'message' => 'Сенсор топлива не найден!'
            ], 400);
        }
        return new FuelSensorResource($fuel_sensor);

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
     * @param FuelSensorRequest $request
     * @param FuelSensor $fuel_sensor
     * @return FuelSensorResource
     */
    public function update(FuelSensorRequest $request, int $id)
    {
        $validated = $request->validated();

        FuelSensor::query()->find($id)->update(
            $validated
        );

        $fuel_sensor = $this->repository->getFuelSensorById($id);

        return new FuelSensorResource($fuel_sensor);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        $fuel_sensor = $this->repository->getFuelSensorById($id);
        $result = null;

        if ($fuel_sensor === null) {
            $result = response()->json([
                'message' => 'Такой записи не существует'
            ], 400);
        } else {
            FuelSensor::query()->find($id)->delete();
            $result = response()->json([
                'message' => 'Запись была успешна удалена'
            ]);
        }

        return $result;
    }
}
