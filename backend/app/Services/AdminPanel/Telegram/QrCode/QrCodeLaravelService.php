<?php

namespace App\Services\AdminPanel\Telegram\QrCode;

use App\Models\User;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Crypt;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrCodeLaravelService implements QrCodeServiceInterface
{
    public function generateFor(User $user)
    {
        $username = Config::get('services.telegram.username');
        $link = "https://t.me/{$username}?start={$user->id}";

        return QrCode::format('png')
            ->size(250)
            ->margin(1)
            ->generate($link);
    }
}
