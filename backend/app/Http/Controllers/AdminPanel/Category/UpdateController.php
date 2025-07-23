<?php

namespace App\Http\Controllers\AdminPanel\Category;

use App\Http\Controllers\BaseController\AdminPanel\BaseCategoryController;
use App\Http\Requests\AdminPanel\Category\UpdateRequest;
use App\Models\Category;

class UpdateController extends BaseCategoryController
{
    public function __invoke(UpdateRequest $request, Category $category)
    {
        $data = $request->validated();
        $category = $this->service->update($data, $category);
        return redirect()->route('category.show', $category->id);
    }
}
