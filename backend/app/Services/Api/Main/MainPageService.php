<?php

namespace App\Services\Api\Main;

use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\Product\ProductResource;
use App\Models\Category;
use App\Models\Product;

class MainPageService
{
    public function index()
    {
        $products = Product::all()->random(6);
        $categories = Category::all()->random(5);
        $bigCategories = Category::all()->random(2);
        
        return [
            'products' => ProductResource::collection($products),
            'categories' => CategoryResource::collection($categories),
            'bigCategories' => CategoryResource::collection($bigCategories),
        ];
    }
}
