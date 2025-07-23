<?php

namespace App\Enums;

enum OrderStatus: string
{
    case AwaitingPriceCalculation = 'awaiting_price_calculation';
    case PendingPayment = 'pending_payment';
    case Processing  = 'processing';
    case Shipped = 'shipped';
    case Delivered = 'delivered';
    case Cancelled = 'cancelled';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function labels(): array
    {
        return [
            self::AwaitingPriceCalculation->value => 'Ожидает подсчёта цены',
            self::PendingPayment->value => 'Ожидает оплаты',
            self::Processing->value => 'Оплачен, в обработке',
            self::Shipped->value => 'Отправлен',
            self::Delivered->value => 'Доставлен',
            self::Cancelled->value => 'Отменён',
        ];
    }

    public function label(): string
    {
        return self::labels()[$this->value];
    }
}

