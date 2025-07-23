<?php

namespace App\Enums;

enum OrderPaymentStatus: string
{
    case Initiated = 'initiated';
    case Pending = 'pending';
    case Succeeded = 'succeeded';
    case Failed  = 'failed';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function labels(): array
    {
        return [
            self::Initiated->value => 'Инициирован',
            self::Pending->value   => 'В ожидании',
            self::Succeeded->value => 'Успешно',
            self::Failed->value    => 'Ошибка',
        ];
    }

    public function label(): string
    {
        return self::labels()[$this->value];
    }
}
