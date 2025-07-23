<?php

namespace App\Services\AdminPanel\Telegram;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TelegramService
{
    protected string $apiUrl;
    protected string $token;

    public function __construct()
    {
        $this->token  = config('services.telegram.bot_token');
        $this->apiUrl = "https://api.telegram.org/bot{$this->token}";
    }

    public function sendMessage($payload): ?array
    {
        $response = Http::post("{$this->apiUrl}/sendMessage", array_filter($payload));

        if (! $response->successful()) {
            Log::error('Telegram API error', [
                'payload' => $payload,
                'body'    => $response->body(),
                'status'  => $response->status(),
            ]);
            return null;
        }


        return $response->json();
    }
}
