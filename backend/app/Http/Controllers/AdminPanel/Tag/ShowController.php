<?php

namespace App\Http\Controllers\AdminPanel\Tag;

use App\Http\Controllers\BaseController\AdminPanel\BaseTagController;
use App\Models\Tag;

class ShowController extends BaseTagController
{
    public function __invoke(Tag $tag)
    {
        return view('tag.show', [
            'header' => $this->service->getHeaderInfo(),
            'tag' => $this->service->getTagFullInfo($tag)
        ]);
    }
}
