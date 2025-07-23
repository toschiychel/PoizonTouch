<?php

namespace App\Http\Controllers\BaseController\AdminPanel;

use App\Http\Controllers\Controller;
use App\Services\AdminPanel\User\UserService;

class BaseUserController extends Controller
{
    protected $service;

    public function __construct(UserService $service) {
        $this->service = $service;
    }
}
