<?php

namespace App\Http\Controllers\Api\Main;

use App\Http\Controllers\BaseController\Api\BaseMainController;

class IndexController extends BaseMainController
{
    public function __invoke()
    {
        $data = $this->service->index();
        return response()->json($data);
    }
}
