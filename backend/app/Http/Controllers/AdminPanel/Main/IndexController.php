<?php

namespace App\Http\Controllers\AdminPanel\Main;

use App\Http\Controllers\BaseController\AdminPanel\BaseMainPageController;

class IndexController extends BaseMainPageController
{
    public function __invoke()
    {
        return view('main.index', [
            'header' => $this->service->getHeaderInfo(),
            'salesData' => $this->service->getSalesData()
        ]);
    }
}
