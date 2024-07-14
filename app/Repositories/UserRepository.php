<?php

namespace App\Repositories;

use App\Contracts\IUserRepository;
use App\DTO\UserDTO;
use App\Models\User;
use Illuminate\Pagination\Paginator;

class UserRepository implements IUserRepository
{

    public function getAllUsers(): Paginator
    {
        return User::simplePaginate(15);
    }

    public function getUserByEmail(string $userEmail): ?User
    {
        /** @var User|null $user */
        $user = User::query()
            ->where('email', $userEmail)
            ->first();

        return $user;
    }

    public function createUser(UserDTO $userDTO): ?User
    {
        $user = new User();
        $user->name = $userDTO->getName();
        $user->email = $userDTO->getEmail();
        $user->password = $userDTO->getPassword();
        $user->status = $userDTO->getStatus() ?? true;
        $user->role = $userDTO->getRole() ?? 'user';
        $user->save();

        return $user;
    }

    public function getUserById(int $user_id): ?User
    {
        /** @var User|null $user */

        $user = User::query()->find($user_id);

        return $user;
    }

    public function deleteUser(User $user): void
    {
        $user->delete();
    }

    public function changeStatus(User $user): void
    {
        $user->status = $user->status ? 0 : 1;
        $user->save();
    }

    public function updateUser(UserDTO $userDTO, User $user): User
    {
        $user->name = $userDTO->getName();
        $user->email = $userDTO->getEmail();
        $user->status = $userDTO->getStatus();
        $user->role = $userDTO->getRole();
        $user->save();

        return $user;
    }


}
