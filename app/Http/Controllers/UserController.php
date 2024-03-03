<?php

namespace App\Http\Controllers;

use App\Contracts\IUserRepository;
use App\DTO\UserDTO;
use App\Exceptions\BusinessException;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Jobs\UserSendSmsJob;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\create\CreateUserService;
use App\Services\update\UpdateUserService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

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

        $user = $service->execute(UserDTO::fromArray($validated));

        UserSendSmsJob::dispatch($user);

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
                'message' => __('messages.user_not_found_error')
            ], 400);
        }
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     * @param UserRequest $request
     * @param User $user
     * @return JsonResponse
     */
    public function update(UserRequest $request, UpdateUserService $service, int $id): JsonResponse
    {
        $validated = $request->validated();

        $user = $this->repository->getUserById($id);

       $service->execute(UserDTO::fromArray($validated), $user);

//        return new UserResource($user);

        return response()->json([
            'message' => 'Пользователь обновлён успешно!'
        ], Response::HTTP_OK);
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
                'message' => __('messages.record_not_found')
            ], 400);
        } else {
            User::query()->find($id)->delete();
            $result = response()->json([
                'message' => __('messages.record_deletion_successful')
            ]);
        }

        return $result;
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
