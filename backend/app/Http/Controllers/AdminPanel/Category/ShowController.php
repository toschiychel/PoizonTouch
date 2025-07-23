<?php

namespace App\Http\Controllers\AdminPanel\Category;

use App\Http\Controllers\BaseController\AdminPanel\BaseCategoryController;
use App\Models\Category;

class ShowController extends BaseCategoryController
{
    public function __invoke(Category $category)
    {   
        return view('category.show', [
            'category' => $this->service->getCategoryFullInfo($category),
            'header' => $this->service->getHeaderInfo()
        ]);
    }
}
