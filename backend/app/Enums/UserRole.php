<?php

namespace App\Enums;

enum UserRole: string
{
    case ADMIN = 'admin';
    case MODERATOR = 'moderator';
    case USER = 'user';

    public function label(): string
    {
        return self::labels()[$this->value];
    }

    public static function labels(): array
    {
        return [
            self::ADMIN->value => 'Администратор',
            self::MODERATOR->value => 'Модератор',
            self::USER->value => 'Пользователь',
        ];
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
