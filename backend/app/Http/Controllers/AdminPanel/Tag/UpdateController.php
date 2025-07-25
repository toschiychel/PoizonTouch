<?php

namespace App\Http\Controllers\AdminPanel\Tag;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminPanel\Tag\UpdateRequest;
use App\Models\Tag;

class UpdateController extends Controller
{
    public function __invoke(UpdateRequest $request, Tag $tag)
    {
        $data = $request->validated();
        $tag->update($data);
        return redirect()->route('tag.show', compact('tag'));
    }
}
