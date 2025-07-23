<?php

namespace App\Http\Controllers\AdminPanel\Color;

use App\Http\Controllers\BaseController\AdminPanel\BaseColorController;

class IndexController extends BaseColorController
{
    public function __invoke()
    {
        return view('color.index', [
            'colors' => $this->service->getPaginatedColors(10),
            'header' => $this->service->getHeaderInfo()
        ]);
    }
}
