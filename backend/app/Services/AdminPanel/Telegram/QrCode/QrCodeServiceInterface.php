<?php

namespace App\Services\AdminPanel\Telegram\QrCode;

use App\Models\User;

interface QrCodeServiceInterface
{
    public function generateFor(User $user);
}
