<?php

namespace App\DTO\Category;

use Carbon\CarbonImmutable;

class CategoryFullInfoDTO
{
    public function __construct(
        public readonly int $id,
        public readonly string $title,
        public readonly string $bigPreviewImageUrl,
        public readonly string $smallPreviewImageUrl,
        public readonly string $created_at,
        public readonly string $updated_at,
        public readonly ?string $deleted_at,
    ) {}
}