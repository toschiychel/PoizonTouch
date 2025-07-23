<?php

namespace App\Http\Controllers\AdminPanel\Product;

use App\Http\Controllers\BaseController\AdminPanel\BaseProductController;
use App\Http\Requests\AdminPanel\Product\UpdateRequest;
use App\Models\Product;

class UpdateController extends BaseProductController
{
    public function __invoke(UpdateRequest $request, Product $product)
    {
        $data = $request->validated();
        $product = $this->service->update($data, $product);
        return redirect()->route('product.show', $product->id);
    }
}
