<?php

namespace App\Http\Controllers\AdminPanel\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminPanel\User\UpdateRequest;
use App\Models\User;

class UpdateController extends Controller
{
    public function __invoke(UpdateRequest $request, User $user)
    {
        $data = $request->validated();
        $user->update($data);
        return redirect()->route('user.show', compact('user'));
    }
}
