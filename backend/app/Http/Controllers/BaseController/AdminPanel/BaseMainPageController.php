<?php

namespace App\Http\Controllers\BaseController\AdminPanel;

use App\Http\Controllers\Controller;
use App\Services\AdminPanel\MainPage\MainPageService;

class BaseMainPageController extends Controller
{
    protected $service;

    public function __construct(MainPageService $service) {
        $this->service = $service;
    }
}
