<?php

namespace App\DTO\Product;

class ProductFullInfoDTO
{
    public function __construct(
        public readonly int $id,
        public readonly string $title,
        public readonly string $description,
        public readonly string $content,
        public readonly string $previewImage,
        public readonly object $images,
        public readonly int $price,
        public readonly float $weight,
        public readonly int $count,
        public readonly string $publicationStatus,
        public readonly object $category,
        public readonly object $tags,
        public readonly object $colors,
        public readonly string $created_at,
        public readonly string $updated_at,
        public readonly ?string $deleted_at,
    ) {}
}