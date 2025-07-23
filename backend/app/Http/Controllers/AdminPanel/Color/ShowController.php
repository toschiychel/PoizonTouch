<?php

namespace App\Http\Controllers\AdminPanel\Color;

use App\Http\Controllers\BaseController\AdminPanel\BaseColorController;
use App\Models\Color;

class ShowController extends BaseColorController
{
    public function __invoke(Color $color)
    {
        return view('color.show', [
            'color' => $this->service->getColorFullInfo($color),
            'header' => $this->service->getHeaderInfo()
        ]);
    }
}
