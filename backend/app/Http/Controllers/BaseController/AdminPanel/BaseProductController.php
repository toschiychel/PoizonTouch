<?php

namespace App\Http\Controllers\BaseController\AdminPanel;

use App\Http\Controllers\Controller;
use App\Services\AdminPanel\Product\ProductService;

class BaseProductController extends Controller
{
    protected $service;

    public function __construct(ProductService $service) {
        $this->service = $service;
    }
}
