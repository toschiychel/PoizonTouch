<?php

namespace App\Notifications\User;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class OrderStatusUpdatedNotification extends Notification
{
    use Queueable;

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
        $date  = now()->format('d.m.Y H:i');
        $url   = route('order.show', $order);

        $text  = "✅ *Ваш заказ* — `#{$order->id}`\n"
               . "⏱ *Время:* {$date}\n"
               . "📊 *Изменил статус из:* `{$this->oldStatus}` → *В:* `{$this->newStatus}`\n"
               . "💰 *Сумма:* {$order->total_price} ₽\n\n"
               . "🔗 [Посмотреть статус]({$url})";

        return [
            'text' => $text,
            'parse_mode' => 'Markdown',
        ];
    }
}
