<?php

namespace App\Http\Controllers\AdminPanel\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminPanel\User\StoreRequest;
use App\Models\User;

class StoreController extends Controller
{
    public function __invoke(StoreRequest $request)
    {   
        $data = $request->validated();
        $user = User::firstOrCreate($data);

        return redirect()->route('user.index', $user->id);
    }
}
