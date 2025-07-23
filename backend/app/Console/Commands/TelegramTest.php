<?php
namespace App\Console\Commands;

use App\Services\AdminPanel\Telegram\TelegramService;
use Illuminate\Console\Command;

class TelegramTest extends Command
{
    protected $signature = 'telegram:test {chatId}';
    protected $description = 'Send test message to Telegram bot';

    public function handle(TelegramService $telegram)
    {
        $chatId = $this->argument('chatId');
        $result = $telegram->sendMessage($chatId, '✅ Тестовое сообщение из Laravel!');
        
        if ($result) {
            $this->info("Сообщение отправлено, message_id={$result['result']['message_id']}");
        } else {
            $this->error('Не удалось отправить сообщение. Проверьте лог.');
        }
    }
}
