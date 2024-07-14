<?php

namespace App\Http\Services;

use App\Contracts\IUserRepository;
use App\DTO\UserDTO;
use App\Exceptions\BusinessException;
use App\Exceptions\DuplicateEntryException;
use App\Exceptions\ModelNotFoundException;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Js;
use Symfony\Component\HttpFoundation\Response;

class LoginRegisterService
{
    /**
     * @var IUserRepository
     */
    private IUserRepository $repository;

    /**
     *
     */
    public function __construct()
    {
        $this->repository = new UserRepository();
    }


    /**
     * @param UserDTO $userDTO
     * @return User
     * @throws DuplicateEntryException
     */
    public function create(UserDTO $userDTO): User
    {
        $userWithEmail = $this->repository->getUserByEmail($userDTO->getEmail());

        if ($userWithEmail !== null) {
            throw new DuplicateEntryException('Пользователь с такой электронной почтой уже существует.');
        }

        return $this->repository->createUser($userDTO);
    }
}
