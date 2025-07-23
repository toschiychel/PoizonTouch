<?php

namespace App\Services\Api\Account;

use Illuminate\Contracts\Auth\StatefulGuard;

class AccountService
{
    public function userOrders($user) {
        return $user->orders()
        ->with('positions')
        ->latest()
        ->get();
    }
}
