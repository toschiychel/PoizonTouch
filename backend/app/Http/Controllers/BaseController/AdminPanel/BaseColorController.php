<?php

namespace App\Http\Controllers\BaseController\AdminPanel;

use App\Http\Controllers\Controller;
use App\Services\AdminPanel\Color\ColorService;

class BaseColorController extends Controller
{
    protected $service;

    public function __construct(ColorService $service) {
        $this->service = $service;
    }
}
