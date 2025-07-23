<?php

namespace App\Services\Api\Product;

use App\Http\Filter\ProductFilter;
use App\Models\Product;

class ProductService
{
    public function indexWithFilters($data)
    {
        $filter = app()->make(ProductFilter::class, ['queryParams' => array_filter($data)]);
        $products = Product::onSale()->filter($filter)->paginate(8, ['*'], 'page', $data['page']);
        return $products;
    }
}
