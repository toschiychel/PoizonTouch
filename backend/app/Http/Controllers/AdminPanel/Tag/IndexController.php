<?php

namespace App\Http\Controllers\AdminPanel\Tag;

use App\Http\Controllers\BaseController\AdminPanel\BaseTagController;

class IndexController extends BaseTagController
{
    public function __invoke()
    {
        return view('tag.index', [
            'tags' => $this->service->getPaginatedTags(10),
            'header' => $this->service->getHeaderInfo()
        ]);
    }
}
