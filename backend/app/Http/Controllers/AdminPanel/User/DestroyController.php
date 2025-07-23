<?php

namespace App\Http\Controllers\AdminPanel\User;

use App\Http\Controllers\Controller;
use App\Models\User;

class DestroyController extends Controller
{
    public function __invoke(User $user)
    {
        $user->delete();
        return redirect()->route('user.index');
    }
}
