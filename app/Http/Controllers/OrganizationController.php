<?php

namespace App\Http\Controllers;

use App\Contracts\IOrganizationRepository;
use App\DTO\OrganizationDTO;
use App\Exceptions\BusinessException;
use App\Http\Requests\OrganizationRequest;
use App\Http\Resources\OrganizationResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\VehicleResource;
use App\Models\Organization;
use App\Repositories\OrganizationRepository;
use App\Services\create\CreateOrganizationService;
use App\Services\update\UpdateOrganizationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response;

class OrganizationController extends Controller
{
    private IOrganizationRepository $repository;

    public function __construct()
    {
        $this->repository = new OrganizationRepository();
    }

    /**
     * Display a listing of the resource.
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $organizations = cache()->remember('organizations', 120, function () {
            return Organization::all();
        });

        return response()->json([
            'data' => $organizations
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
     * @param OrganizationRequest $request
     * @return OrganizationResource
     * @throws BusinessException
     */
    public function store(OrganizationRequest $request, CreateOrganizationService $service): OrganizationResource
    {
        $validated = $request->validated();

        $organization = $service->execute(OrganizationDTO::fromArray($validated));

        return new OrganizationResource($organization);
    }

    /**
     * Display the specified resource.
     * @param Organization $organization
     * @return OrganizationResource
     */
    public function show(string $id): OrganizationResource|JsonResponse
    {
        $organization = $this->repository->getOrganizationById($id);

        if ($organization === null) {
            return response()->json([
                'message' => 'Организация не найдена!'
            ], 400);
        }
        return new OrganizationResource($organization);

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
     * @param OrganizationRequest $request
     * @param Organization $organization
     * @return JsonResponse
     */
    public function update(OrganizationRequest $request,UpdateOrganizationService $service, int $id): JsonResponse
    {
        $validated = $request->validated();

        $organization = $this->repository->getOrganizationById($id);

        $service->execute(OrganizationDTO::fromArray($validated), $organization);

        return response()->json([
            'message' => 'Организация обновлёна успешно!'
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     * @return JsonResponse
     */
//    public function destroy(Organization $organization, int $id)
    public function destroy(int $id): JsonResponse
    {
        $organization = $this->repository->getOrganizationById($id);
        $result = null;


        if ($organization === null) {
            $result = response()->json([
                'message' => 'Такой записи не существует'
            ], 400);
        } else {
            Organization::query()->find($id)->delete();
            $result = response()->json([
                'message' => 'Запись была успешна удалена'
            ]);
        }

        return $result;
    }


    /**
     * @param int $organization_id
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function getOrganizationUsers(
        int $organization_id
    ): JsonResponse|AnonymousResourceCollection
    {
        /** @var Organization|null $organization */
        $organization = Organization::query()->find($organization_id);


        if ($organization === null) {
            return response()->json([
                'message' => 'Организация не найдена!'
            ], 400);
        }

//
        $users = $organization->users;


        return UserResource::collection($users);
    }

    public function getOrganizationUserById(
        int $organization_id,
        int $user_id,
    ): JsonResponse|UserResource
    {
        /** @var Organization|null $organization */
        $organization = Organization::query()->find($organization_id);

        if ($organization === null) {
            return response()->json([
                'message' => 'Организация не найдена!'
            ], 400);
        }

        $user = $organization->users()->find($user_id);

        if ($user === null) {
            return response()->json([
                'message' => 'Пользователь не найден!'
            ], 400);
        }

        return new UserResource($user);
    }


    /**
     * @param int $organization_id
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function getOrganizationVehicles(
        int $organization_id
    ): JsonResponse|AnonymousResourceCollection
    {
        /** @var Organization|null $organization */
        $organization = Organization::query()->find($organization_id);


        if ($organization === null) {
            return response()->json([
                'message' => 'Организация не найдена!'
            ], 400);
        }

        $vehicles = $organization->vehicles()->get();


        return VehicleResource::collection($vehicles);
    }

    public function getOrganizationVehicleById(
        int $organization_id,
        int $vehicle_id,
    ): JsonResponse|VehicleResource
    {
        /** @var Organization|null $organization */
        $organization = Organization::query()->find($organization_id);

        if ($organization === null) {
            return response()->json([
                'message' => 'Организация не найдена!'
            ], 400);
        }

        $vehicle = $organization->vehicles()->find($vehicle_id);

        if ($vehicle === null) {
            return response()->json([
                'message' => 'Транспорт не найден!'
            ], 400);
        }

        return new VehicleResource($vehicle);
    }
}
