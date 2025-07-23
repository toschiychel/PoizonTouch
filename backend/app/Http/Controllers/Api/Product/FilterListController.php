<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Http\Request;

class FilterListController extends Controller
{
    public function __invoke(Request $request)
    {
        try {
            $categories = Category::all();
            $colors = Color::all();
            $tags = Tag::all();

            $maxPrice = Product::orderBy('price', 'DESC')->first()->price;
            $minPrice = Product::orderBy('price', 'ASC')->first()->price;

            $result = [
                'categories' => $categories,
                'tags' => $tags,
                'colors' => $colors,
                'price' => [
                    'max' => $maxPrice,
                    'min' => $minPrice
                ]
            ];

            return response()->json($result);
        } catch (\Throwable $th) {
            $maxPrice = 100;
            $minPrice = 1;

            $result = [
                'price' => [
                    'max' => $maxPrice,
                    'min' => $minPrice
                ]
            ];
            return response()->json($result);
        }
    }
}
