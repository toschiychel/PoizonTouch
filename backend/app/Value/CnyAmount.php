<?php

namespace App\Value;

class CnyAmount
{
    public function toRub($rate, $cny_price): float
    {
        return $cny_price * $rate;
    }
}
