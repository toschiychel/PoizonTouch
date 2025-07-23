<?php

namespace App\DTO;

class OrderDeliveryEventDTO
{
    public function __construct(
        public $id,
        public $status,
        public $description,
        public $location,
        public $happenedAt
    ) {}
}
