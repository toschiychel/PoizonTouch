<?php

namespace App\Http\Controllers\AdminPanel\User;

use App\Enums\UserRole;
use App\Http\Controllers\BaseController\AdminPanel\BaseUserController;
use App\Models\User;

class ShowController extends BaseUserController
{
    public function __invoke(User $user)
    {
        return view('user.show', [
            'header' => $this->service->getHeaderInfo(),
            'user' => $this->service->getUserFullInfo($user),
            'userRoles' => UserRole::labels()
        ]);
    }
}
