<?php

namespace App\Http\Controllers\AdminPanel\Tag;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminPanel\Tag\StoreRequest;
use App\Models\Tag;

class StoreController extends Controller
{
    public function __invoke(StoreRequest $request)
    {   
        $data = $request->validated();
        $tag = Tag::firstOrCreate($data);
        return redirect()->route('tag.index');
    }
}
