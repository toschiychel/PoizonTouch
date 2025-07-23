<?php

namespace App\Http\Controllers\BaseController\Api;

use App\Services\Api\Account\AccountService;
use App\Services\Api\Account\LoginService;

class BaseAccountController
{
    protected $service;
    protected $loginService;

    public function __construct(AccountService $service, LoginService $loginService) {
        $this->service = $service;
        $this->loginService = $loginService;
    }
}
