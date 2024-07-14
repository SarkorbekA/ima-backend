<?php

namespace App\DTO;

class UserDTO
{
    public function __construct(
        private readonly string|null $name,
        private readonly string|null $email,
        private readonly string|null $password,
        private readonly string|null $status,
        private readonly string|null $role,
    )
    {

    }

    public function getName(): string|null
    {
        return $this->name;
    }

    public function getEmail(): string|null
    {
        return $this->email;
    }


    public function getPassword(): string|null
    {
        return $this->password;
    }

    public function getStatus(): string|null
    {
        return $this->status;
    }

    public function getRole(): string|null
    {
        return $this->role;
    }


    public static function fromArray(array $data): static
    {
        return new static(
            name: $data['name'] ?? null,
            email: $data['email'] ?? null,
            password: $data['password'] ?? null,
            status: $data['status'] ?? null,
            role: $data['role'] ?? null,
        );
    }
}
