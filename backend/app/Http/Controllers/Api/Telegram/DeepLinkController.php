<?php

namespace App\Http\Controllers\Api\Telegram;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DeepLinkController extends Controller
{
    public function __invoke(Request $request)
    {
        $payload = encrypt(['user_id' => auth()->id(), 'ts' => now()->timestamp]);
        $bot = config('services.telegram.username');
        return response()->json([
            'url' => "https://t.me/{$bot}?start={$payload}"
        ]);
    }
}
