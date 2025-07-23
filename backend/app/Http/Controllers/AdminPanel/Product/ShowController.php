<?php

namespace App\Http\Controllers\AdminPanel\Product;

use App\Http\Controllers\BaseController\AdminPanel\BaseProductController;
use App\Models\Product;

class ShowController extends BaseProductController
{
    public function __invoke(Product $product)
    {
        return view('product.show', [
            'header' => $this->service->getHeaderInfo(),
            'product' => $this->service->getProductFullInfo($product),
        ]);
    }
}
