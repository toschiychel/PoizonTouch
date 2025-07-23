<?php

namespace App\Listeners\Admin;

use App\Events\Order\StatusUpdated;
use App\Notifications\Admin\OrderStatusUpdatedNotification;
use Illuminate\Support\Facades\Notification;

class NotifyOfStatusChange
{
     public function handle(StatusUpdated $event): void
    {
        $chatId = config('notifications.admin_telegram_chat_id');

        Notification::route('telegram', $chatId)
            ->notify(new OrderStatusUpdatedNotification(
                $event->order,
                $event->oldStatus,
                $event->newStatus
            ));
    }
}
