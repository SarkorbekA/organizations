<?php

namespace App\Http\Controllers;

use App\Contracts\IUserRepository;
use App\DTO\UserDTO;
use App\Exceptions\BusinessException;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Jobs\UserSendEmail;
use App\Jobs\UserSendSmsJob;
use App\Models\Organization;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\CreateUserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UserController extends Controller
{
    private IUserRepository $repository;

    public function __construct()
    {
        $this->repository = new UserRepository();
    }

    /**
     * Display a listing of the resource.
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
//        $users = User::all();

        $users = cache()->remember('users', 120, function () {
            return User::all();
        });

        return response()->json([
            'data' => $users
        ]);

    }

    /**
     * Store a newly created resource in storage.
     * @param UserRequest $request
     * @return UserResource
     * @throws BusinessException
     */
    public function store(UserRequest $request, CreateUserService $service): UserResource
    {
        $validated = $request->validated();

//        $service = new CreateUserService();
        $user = $service->execute(UserDTO::fromArray($validated));

//        UserSendEmail::dispatch($user);
//        UserSendSmsJob::dispatch($user);

        return new UserResource($user);
    }

    /**
     * Display the specified resource.
     * @param User $user
     * @return UserResource
     */

    public function show(int $id): UserResource|JsonResponse
    {
        $user = $this->repository->getUserById($id);

        if ($user === null) {
            return response()->json([
                'message' => 'Пользователь не найден!'
            ], 400);
        }
        return new UserResource($user);

    }

    /**
     * Update the specified resource in storage.
     * @param UserRequest $request
     * @param User $user
     * @return UserResource
     */
    public function update(UserRequest $request, int $id)
    {

        $validated = $request->validated();

        $user = $this->repository->getUserById($id);

        $user->update($validated);

        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $user = $this->repository->getUserById($id);


        if ($user === null) {
            $result = response()->json([
                'message' => 'Такой записи не существует'
            ], 400);
        } else {
            User::query()->find($id)->delete();
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
}

// http://my-app.loc.uz/api/users/:user_id
// domain/organizations/org_id/users
// domain/organizations/org_id/users/user_id


//        $validated = $request->validate([
//            'name' => 'required|string|max:50',
//            'surname' => 'required|string|max:50',
//            'age' => 'required|integer|min:0',
//            'email' => 'required|email',
//        ]);
