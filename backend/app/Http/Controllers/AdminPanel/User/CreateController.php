<?php

namespace App\Http\Controllers\AdminPanel\User;

use App\Enums\UserRole;
use App\Http\Controllers\BaseController\AdminPanel\BaseUserController;
use Illuminate\Http\Request;

class CreateController extends BaseUserController
{
    public function __invoke(Request $request)
    {
        return view('user.create', [
            'header' => $this->service->getHeaderInfo(),
            'roles' => UserRole::labels()
        ]);
    }
}
