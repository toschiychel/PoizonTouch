<?php

namespace App\Http\Controllers\AdminPanel\Product;

use App\Http\Controllers\BaseController\AdminPanel\BaseProductController;
use App\Http\Requests\AdminPanel\Product\StoreRequest;

class StoreController extends BaseProductController
{
    public function __invoke(StoreRequest $request)
    {    
        $data = $request->validated(); 
        $product = $this->service->store($data);
        return redirect()->route('product.index', $product->id);
    }
}
