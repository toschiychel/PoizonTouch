<?php

namespace App\Console\Commands;

use App\Services\Api\Telegram\TelegramPollService;
use Illuminate\Console\Command;

class PollTelegramUpdates extends Command
{
    /**
     * Имя и сигнатура команды.
     *
     * @var string
     */
    protected $signature = 'telegram:poll';

    /**
     * Описание команды.
     *
     * @var string
     */
    protected $description = 'Poll Telegram Bot API for new updates and handle /start links';

    /**
     * Выполнение команды.
     */
    public function handle(TelegramPollService $pollService): void
    {
        $this->info('Polling Telegram for updates…');
        $pollService->pollAndHandle();
        $this->info('Done.');
    }
}
