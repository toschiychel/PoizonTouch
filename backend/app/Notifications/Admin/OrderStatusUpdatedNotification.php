<?php

namespace App\Notifications\Admin;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderStatusUpdatedNotification extends Notification
{
     public function __construct(
        protected Order $order,
        protected string $oldStatus,
        protected string $newStatus
    ) {}

    public function via($notifiable): array
    {
        return ['telegram'];
    }

    public function toTelegram($notifiable): array
    {
        $order = $this->order;
        $old = $this->oldStatus;
        $new = $this->newStatus;
        $date = now()->format('d.m.Y H:i');
        $url  = route('order.show', $this->order);

        $text  = "🔄 *Статус заказа* — `#{$order->id}`\n"
               . "⏱ *Время:* {$date}\n"
               . "📊 *Из:* `{$old}` → *В:* `{$new}`\n"
               . "💰 *Сумма:* {$order->total_price} ₽\n"
               . "👥 *Клиент:* {$order->user->email}\n\n"
               . "🔗 [Открыть заказ](" . route('order.show', $order) . ")";

        return [
            'text' => $text,
            'parse_mode' => 'Markdown',
        ];
    }
}
