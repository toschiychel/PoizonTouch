<?php

namespace App\Services\AdminPanel\Order;

use App\Models\Order;
use App\Services\AdminPanel\Currency\CurrencyRateService;

class OrderCalculationService
{
    protected $currencyService;
    public function __construct(CurrencyRateService $currencyService) {
        $this->currencyService = $currencyService;
    }
    
    public function calculate(Order $order): void
    {
        $order->load('positions');
        $total = 0;
        $cnyRubRate = $this->currencyService->getActualRate();

        foreach ($order->positions as $position) {
            if ($position->type === 'product' || $position->type === 'delivery') {
                $total += $position->unit_price * $position->quantity;
            } elseif ($position->type === 'link' && $position->price_cny) {
                $converted = $position->price_cny * $cnyRubRate;
                $position->converted_price_rub = $converted;
                $position->save();
                $total += $converted * $position->quantity;
            }
        }

        $order->total_price = (int) $total;
        $order->save();
    }
}
