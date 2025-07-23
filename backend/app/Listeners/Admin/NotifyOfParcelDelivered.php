<?php

namespace App\Listeners\Admin;

use App\Events\DeliveryStatusDelivered;
use App\Events\Order\DeliveryStatusDelivered as OrderDeliveryStatusDelivered;
use App\Notifications\Admin\ParcelDeliveredNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class NotifyOfParcelDelivered
{
    public function handle(OrderDeliveryStatusDelivered $event): void
    {
        $deliveryStatus = $event->deliveryStatus;
        $order = $deliveryStatus->order;
        $chatId = config('notifications.admin_telegram_chat_id');

        Notification::route('telegram', $chatId)
            ->notify(new ParcelDeliveredNotification($order, $deliveryStatus));
    }
}
