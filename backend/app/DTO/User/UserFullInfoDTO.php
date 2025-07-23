<?php

namespace App\DTO\User;

class UserFullInfoDTO
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly ?string $surname,
        public readonly string $email,
        public readonly ?string $phone,
        public readonly ?string $address,
        public readonly string $role,
        public readonly ?object $orders,
        public readonly string $created_at,
        public readonly string $updated_at,
        public readonly ?string $deleted_at,
    ) {}
}