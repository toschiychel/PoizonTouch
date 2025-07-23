<?php

namespace App\Http\Controllers\AdminPanel\User;

use App\Http\Controllers\BaseController\AdminPanel\BaseUserController;

class IndexController extends BaseUserController
{
    public function __invoke()
    {
        return view('user.index', [
            'users' => $this->service->getPaginatedUsers(10),
            'header' => $this->service->getHeaderInfo()
        ]);
    }
}
