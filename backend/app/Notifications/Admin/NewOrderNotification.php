<?php

namespace App\Notifications\Admin;

use App\Models\Order;
use Illuminate\Notifications\Notification;

class NewOrderNotification extends Notification
{
    public function __construct(protected Order $order) {}

    public function via($notifiable)
    {
        return ['telegram'];
    }

    public function toTelegram($notifiable)
    {
        $order = $this->order;
        $hasPoizon = $order->positions->contains(fn($p) => $p->type === 'link');
        $itemsCount = $order->positions->sum('quantity');
        $createdAt = $order->created_at->format('d.m.Y H:i');
        $status = $order->status->label();

        $text  = "🆕 *Новый заказ* — `#{$order->id}`\n"
            . "⏱ *Дата:* {$createdAt}\n"
            . "💰 *Сумма:* {$order->total_price} ₽\n"
            . "👥 *Клиент:* {$order->user->email}\n"
            . "📦 *Позиций:* {$itemsCount}\n"
            . "🔄 *Статус:* {$status}\n"
            . "📦 *Poizon-ссылки:* " . ($hasPoizon ? "есть — требуется конвертация" : "нет") . "\n"
            . "📞 *Телефон:* " . ($order->contact->phone ?? '—') . "\n"
            . "📍 *Адрес:* " . ($order->contact->address ?? '—') . "\n"
            . "Примечание к заказу: " . ($order->contact->note ?? '_') . "\n\n"
            . "🔗 [Перейти в админку](" . route('order.show', $order) . ")";


        return [
            'text' => $text,
            'parse_mode' => 'Markdown',
        ];
    }
}
