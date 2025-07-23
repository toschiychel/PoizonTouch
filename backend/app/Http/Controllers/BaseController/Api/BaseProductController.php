<?php

namespace App\Http\Controllers\BaseController\Api;

use App\Services\Api\Product\ProductService;

class BaseProductController
{
    protected $service;

    public function __construct(ProductService $service) {
        $this->service = $service;
    }
}
