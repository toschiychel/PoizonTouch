<?php

namespace App\Http\Controllers\AdminPanel\Product;

use App\Http\Controllers\BaseController\AdminPanel\BaseProductController;

class CreateController extends BaseProductController
{
    public function __invoke()
    {
        return view('product.create', [
            'header' => $this->service->getHeaderInfo(),
            'productRelations' => $this->service->getProductRelations()
        ]);
    }
}
