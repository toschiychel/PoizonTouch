<?php

namespace App\Http\Controllers\Api\Account;

use App\Http\Controllers\BaseController\Api\BaseAccountController;
use Illuminate\Http\Request;

class LoginController extends BaseAccountController
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (!$this->loginService->attemptLogin($credentials)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $this->loginService->regenerateSession($request);

        return response()->json(['message' => 'Authenticated'], 200);
    }
}
