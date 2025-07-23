<?php

namespace App\Http\Controllers\AdminPanel\Category;

use App\Http\Controllers\BaseController\AdminPanel\BaseCategoryController;

class IndexController extends BaseCategoryController
{
    public function __invoke()
    {
        return view('category.index', [
            'categories' => $this->service->getPaginatedCategories(10),
            'header' => $this->service->getHeaderInfo()
        ]);
    }
}
