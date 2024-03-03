<?php

namespace App\Services\update;

use App\Contracts\IUserRepository;
use App\DTO\UserDTO;
use App\Exceptions\BusinessException;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class UpdateUserService
{
    private IUserRepository $repository;

    public function __construct()
    {
        $this->repository = new UserRepository();
    }

    public function execute(UserDTO $userDTO, User $user): User
    {
        $userWithEmail = $this->repository->getUserByEmail($userDTO->getEmail());

//        dd($user->email);
        if ($userWithEmail !== null) {
            throw new BusinessException('Пользователь с такой почтой уже существует.');
        } else if ($user->email !== $userDTO->getEmail()) {
            return $this->repository->updateUser($userDTO, $user);
        }
    }
}
