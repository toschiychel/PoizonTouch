<?php

namespace App\Http\Controllers\BaseController\AdminPanel;

use App\Http\Controllers\Controller;
use App\Services\AdminPanel\Tag\TagService;

class BaseTagController extends Controller
{
    protected $service;

    public function __construct(TagService $service) {
        $this->service = $service;
    }
}
