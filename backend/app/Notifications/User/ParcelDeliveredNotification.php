<?php

namespace App\Notifications\User;

use App\Models\DeliveryStatus;
use App\Models\Order;
use Illuminate\Notifications\Notification;

class ParcelDeliveredNotification extends Notification
{
    public function __construct(
        protected Order $order,
        protected DeliveryStatus $deliveryStatus
    ) {}

    public function via($notifiable): array
    {
        return ['telegram'];
    }

    public function toTelegram($notifiable): array
    {
        $order = $this->order;
        $addr  = $order->contact->address;

        $text  = "📬 *Ваш заказ доставлен!*\n\n"
            . "📦 Заказ: `#{$order->id}`\n"
            . "💰 На сумму: {$order->total_price} ₽\n"
            . "📍 Адрес доставки: {$addr}\n"
            . "🆔 Трек-номер: {$this->deliveryStatus->tracking_number}\n\n"
            . "🔗 [Открыть заказ](" . route('order.show', $order) . ")";

        return [
            'text'       => $text,
            'parse_mode' => 'Markdown',
        ];
    }
}
