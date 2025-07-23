<?php

namespace App\Services\AdminPanel\Order\DeliveryStatus\GdePosylka\RussianPost;

class RussianPostStatusMapper
{
    protected const MAP = [
        1  => 'single',           // Единичный
        2  => 'arrived_pickup',   // Прибыло в место вручения
        3  => 'arrived_sort',     // Прибыло в сортировочный центр
        4  => 'left_sort',        // Покинуло сортировочный центр
        24 => 'notice_sent',      // Направлено извещение
        25 => 'notice_delivered', // Доставлено извещение
    ];

    public static function toKey(int $code): string
    {
        if (array_key_exists($code, self::MAP)) {
            return self::MAP[$code];
        }
        
        return 'unknown';
    }
}
