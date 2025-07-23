<?php

namespace App\Http\Controllers\BaseController\AdminPanel;

use App\Http\Controllers\Controller;
use App\Services\AdminPanel\Category\CategoryService;

class BaseCategoryController extends Controller
{
    protected $service;

    public function __construct(CategoryService $service) {
        $this->service = $service;
    }
}
