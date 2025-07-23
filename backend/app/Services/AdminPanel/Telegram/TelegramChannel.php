<?php

namespace App\Services\AdminPanel\Telegram;

use Illuminate\Notifications\Notification;
use App\Services\AdminPanel\Telegram\TelegramService;
use Illuminate\Support\Facades\Log;

class TelegramChannel
{
    public function __construct(protected TelegramService $telegram) {}

    public function send($notifiable, Notification $notification)
    {
        // Получаем полезные данные из уведомления
        $data = $notification->toTelegram($notifiable);

        Log::warning($notifiable->routeNotificationFor('telegram'));

        $chatId = $notifiable->routeNotificationFor('telegram') ?: config('services.telegram.admin_telegram_chat_id');

        $payload = [
            'chat_id' => $chatId,
            'text' => $data['text'],
            'parse_mode' => $data['parse_mode'] ?? 'Markdown',
        ];
        Log::debug('TelegramChannel send():', ['chat_id' => $chatId, 'text' => $data['text']]);
        Log::info('TelegramChannel payload:', $payload);

        return $this->telegram->sendMessage($payload);
    }
}
