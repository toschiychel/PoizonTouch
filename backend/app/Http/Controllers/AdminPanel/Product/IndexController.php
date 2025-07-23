<?php

namespace App\Http\Controllers\AdminPanel\Product;

use App\Http\Controllers\BaseController\AdminPanel\BaseProductController;

class IndexController extends BaseProductController
{
    public function __invoke()
    {
        return view('product.index', [

            'products' => $this->service->getPaginatedProducts(10),
            'header' => $this->service->getHeaderInfo()
        ]);
    }
}
