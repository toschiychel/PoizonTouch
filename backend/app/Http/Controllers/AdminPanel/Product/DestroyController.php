<?php

namespace App\Http\Controllers\AdminPanel\Product;

use App\Http\Controllers\BaseController\AdminPanel\BaseProductController;
use App\Models\Product;

class DestroyController extends BaseProductController
{
    public function __invoke(Product $product)
    {
        $this->service->destroy($product);
        return redirect()->route('product.index');
    }
}
