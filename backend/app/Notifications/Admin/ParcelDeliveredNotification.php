<?php

namespace App\Notifications\Admin;

use App\Models\DeliveryStatus;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
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

        $text  = "📬 *Посылка доставлена!*\n\n"
            . "📦 Заказ: `#{$order->id}`\n"
            . "👥 Клиент: {$order->user->email}\n"
            . "💰 Сумма: {$order->total_price} ₽\n"
            . "📍 Адрес доставки: {$addr}\n"
            . "🆔 Трек-номер: {$this->deliveryStatus->tracking_number}\n\n"
            . "🔗 [Открыть заказ](" . route('order.show', $order) . ")";

        return [
            'text'       => $text,
            'parse_mode' => 'Markdown',
        ];
    }
}
