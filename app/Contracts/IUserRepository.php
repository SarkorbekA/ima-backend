<?php

namespace App\Contracts;

use App\DTO\UserDTO;
use App\Models\User;
use Illuminate\Pagination\Paginator;

interface IUserRepository
{
    public function getUserByEmail(string $userEmail): ?User;

    public function getAllUsers(): Paginator;

    public function createUser(UserDTO $userDTO): ?User;

    public function getUserById(int $user_id): ?User;

    public function deleteUser(User $user): void;
    public function updateUser(UserDTO $userDTO, User $user): User;
    public function changeStatus(User $user): void;
}
