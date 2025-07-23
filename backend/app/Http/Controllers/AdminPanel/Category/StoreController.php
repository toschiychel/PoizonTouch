<?php

namespace App\Http\Controllers\AdminPanel\Category;

use App\Http\Controllers\BaseController\AdminPanel\BaseCategoryController;
use App\Http\Requests\AdminPanel\Category\StoreRequest;

class StoreController extends BaseCategoryController
{
    public function __invoke(StoreRequest $request)
    {   
        $data = $request->validated();
        $category = $this->service->store($data);
        return redirect()->route('category.index');
    }
}
