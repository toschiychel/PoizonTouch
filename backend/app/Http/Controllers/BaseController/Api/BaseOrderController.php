<?php

namespace App\Http\Controllers\BaseController\Api;

use App\Services\Api\Order\OrderService;

class BaseOrderController
{
    protected $service;

    public function __construct(OrderService $service) {
        $this->service = $service;
    }
}
