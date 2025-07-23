<?php

namespace App\Services\Api\Account;

use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Support\Facades\Auth;

class LoginService
{
    protected StatefulGuard $guard;

    public function __construct(StatefulGuard $guard = null)
    {
        // Используем default guard, если не передан в конструктор
        $this->guard = $guard ?: Auth::guard('web'); 
    }

    public function attemptLogin(array $credentials): bool
    {
        return $this->guard->attempt($credentials);
    }

    public function regenerateSession($request): void
    {
        $request->session()->regenerate();
    }
}
