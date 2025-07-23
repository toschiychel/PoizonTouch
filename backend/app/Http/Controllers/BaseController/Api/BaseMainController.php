<?php

namespace App\Http\Controllers\BaseController\Api;

use App\Services\Api\Main\MainPageService;

class BaseMainController
{
    protected $service;

    public function __construct(MainPageService $service) {
        $this->service = $service;
    }
}
