<?php
namespace App\Services\Api\Telegram;

use App\Models\User;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TelegramPollService
{
    protected string $apiUrl;

    public function __construct()
    {
        $token      = config('services.telegram.bot_token');
        $this->apiUrl = "https://api.telegram.org/bot{$token}";
    }

    public function pollAndHandle(): void
    {
        try {
            $response = Http::timeout(5)
                ->retry(1, 100)
                ->withOptions(['curl' => [CURLOPT_TIMEOUT => 20]])
                ->get("{$this->apiUrl}/getUpdates", [
                    'timeout' => 25,
                    'offset'  => cache('tg_offset', 0),
                ]);
        } catch (ConnectionException $e) {
            Log::warning('Telegram timeout', ['msg'=>$e->getMessage()]);
            return;
        }

        $updates = $response->json('result', []);
        foreach ($updates as $upd) {
            cache()->forever('tg_offset', $upd['update_id'] + 1);

            $text   = $upd['message']['text'] ?? '';
            $chatId = $upd['message']['chat']['id'] ?? null;

            Log::debug("MSG from {$chatId}: {$text}");

            if (preg_match('/^\/start\s+(\d+)$/', trim($text), $m)) {
                $userId = (int)$m[1];
                if ($user = User::find($userId)) {
                    $user->telegram_chat_id = $chatId;
                    $user->save();
                    Log::info("Bound user {$userId} to chat {$chatId}");
                    $this->sendMessage($chatId, "✅ Telegram привязка прошла успешно.");
                } else {
                    $this->sendMessage($chatId, "❌ Пользователь {$userId} не найден.");
                }

            } elseif (trim($text) === '/start') {
                $this->sendMessage($chatId,
                  "👋 Чтобы привязать Telegram, на сайте в личном кабинете нажмите «Добавить Telegram» и отсканируйте QrCode.");
            }
        }
    }

    protected function sendMessage(int $chatId, string $text): void
    {
        Http::post("{$this->apiUrl}/sendMessage", [
            'chat_id' => $chatId,
            'text'    => $text,
        ]);
    }
}
