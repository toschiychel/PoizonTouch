<?php

namespace App\DTO;

class OrderDTO
{
    public function __construct(
        public $id,
        public $orderNumber,
        public $totalPrice,
        public $createdAt,
        public $user,
        public $contacts,
        public $status,
        public $positions,
        public $calculated,
        public $deliveryInfo
    ) {}
}
