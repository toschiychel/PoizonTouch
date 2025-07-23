<?php

namespace App\DTO;

class OrderPositionDTO
{
    public function __construct(
        public $id,
        public $type,
        public $title,
        public $convertedPriceRub,
        public $weight,
        public $priceCny,
        public $linkUrl,
        public $quantity,
        public $unitPrice,
        public $previewImage,
        public $isCalculated,
    ) {}
}
