<?php

namespace App\Listeners\Admin\Order;

use App\Events\Order\OrderCreated;
use App\Notifications\Admin\NewOrderNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class NotifyOfNewOrder
{
    public function handle(OrderCreated $event): void
    {
        Log::debug('NotifyOfNewOrder backtrace:', debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 5));

        $chatId = config('notifications.admin_telegram_chat_id');

        // отправляем «маршрутизированное» уведомление в Telegram
        Notification::route('telegram', $chatId)
                    ->notify(new NewOrderNotification($event->order));
    }
}
