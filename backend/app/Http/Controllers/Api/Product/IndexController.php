<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Controllers\BaseController\Api\BaseProductController;
use App\Http\Requests\Api\Product\FilterRequest;
use App\Http\Resources\Product\ProductResource;

class IndexController extends BaseProductController
{
    public function __invoke(FilterRequest $request)
    {
        $data = $request->validated();
        $products = $this->service->indexWithFilters($data);
        return ProductResource::collection($products);
    }
}
