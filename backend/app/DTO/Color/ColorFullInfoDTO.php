<?php

namespace App\DTO\Color;

class ColorFullInfoDTO
{
    public function __construct(
        public readonly int $id,
        public readonly string $title,
        public readonly string $hex,
        public readonly string $created_at,
        public readonly string $updated_at,
        public readonly ?string $deleted_at,
    ) {}
}