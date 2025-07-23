<?php

namespace App\DTO;

class OrderContactDTO
{
    public function __construct(
        public $first_name,
        public $last_name,
        public $phone,
        public $email,
        public $address,
        public $note,
    ) {}
}
