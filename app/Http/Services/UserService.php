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

class UserService
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
     * @return Paginator
     */
    public function index(): Paginator
    {
        return $this->repository->getAllUsers();
    }


    /**
     * @param UserDTO $userDTO
     * @return JsonResponse
     * @throws DuplicateEntryException
     */
    public function create(UserDTO $userDTO): JsonResponse
    {
        $userWithEmail = $this->repository->getUserByEmail($userDTO->getEmail());

        if ($userWithEmail !== null) {
            throw new DuplicateEntryException('Пользователь с такой электронной почтой уже существует.');
        }

       $data = $this->repository->createUser($userDTO);

        return response()->json([
            'message' => "Пользователь создан успешно!",
            'data' => new UserResource($data)
        ], Response::HTTP_OK);
    }

    /**
     * @param int $id
     * @return User|JsonResponse
     * @throws ModelNotFoundException
     */
    public function delete(int $id): User|JsonResponse
    {
        $userWithId = $this->repository->getUserById($id);

        if ($userWithId === null) {
            throw new ModelNotFoundException('Запись не найдена');
        }


        $this->repository->deleteUser($userWithId);

        return response()->json([
            'message' => 'Запись удалена успешно!',
        ], Response::HTTP_OK);
    }

    /**
     * @param int $id
     * @return User|JsonResponse
     * @throws ModelNotFoundException
     */
    public function changeStatus(int $id): User|JsonResponse
    {
        $userWithId = $this->repository->getUserById($id);

        if ($userWithId === null) {
            throw new ModelNotFoundException('Запись не найдена');
        }

        $this->repository->changeStatus($userWithId);

        return response()->json([
            'message' => 'Статус изменён успешно!',
        ], Response::HTTP_OK);
    }

    /**
     * @param UserDTO $userDTO
     * @param int $id
     * @return JsonResponse
     * @throws ModelNotFoundException
     */
    public function update(UserDTO $userDTO, int $id): JsonResponse
    {
        $userWithId = $this->repository->getUserById($id);

        if ($userWithId === null) {
            throw new ModelNotFoundException('Запись не найдена.');
        }

        $data = new UserResource($this->repository->updateUser($userDTO, $userWithId));

        return response()->json([
            'message' => "Запись обновлена успешно!",
            'data' => $data,
        ], Response::HTTP_OK);
    }

    /**
     * @param int $id
     * @return UserResource
     * @throws ModelNotFoundException
     */
    public function show(int $id): UserResource
    {
        $userWithId = $this->repository->getUserById($id);

        if ($userWithId === null) {
            throw new ModelNotFoundException('Запись не найдена.');
        }

        return new UserResource($userWithId);
    }
}
