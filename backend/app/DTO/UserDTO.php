<?php

namespace App\DTO;

class UserDTO
{
    public function __construct(
        public $id,
        public $name,
        public $email,
    ) {}
}
