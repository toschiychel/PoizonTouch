<?php

namespace App\Http\Controllers\AdminPanel\Product;

use App\Http\Controllers\BaseController\AdminPanel\BaseProductController;
use App\Models\Product;

class EditController extends BaseProductController
{
    public function __invoke(Product $product)
    {   
        return view('product.edit', [
            'header' => $this->service->getHeaderInfo(),
            'product' => $this->service->getProductFullInfo($product),
            'productRelations' => $this->service->getProductRelations()
        ]);
    }
}
