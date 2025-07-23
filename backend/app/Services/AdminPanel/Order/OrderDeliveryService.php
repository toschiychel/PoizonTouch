<?php

namespace App\Services\AdminPanel\Order;

use App\Models\Delivery;
use App\Models\Order;

class OrderDeliveryService
{
    public function calculate(Order $order)
    {
        $order->load('positions');
        $totalWeight = 0;
        foreach ($order->positions as $position) {
            $totalWeight += $position->weight * $position->quantity;
        }

        if ($order->positions->contains(fn($pos) => $pos->type === 'delivery')) {
            $delivery = $order->positions->first(fn($pos) => $pos->type === 'delivery');
            $delivery->unit_price = $totalWeight * Delivery::getDefault()->price_per_kg;
            $delivery->save();
        } else {
            $order->positions()->create([
                'order_id' => $order->id,
                'type' => 'delivery',
                'title' => 'Доставка',
                'preview_image_path' => 'products/delivery.jpg',
                'unit_price' => $totalWeight * Delivery::getDefault()->price_per_kg,
                'quantity' => 1,
            ]);
        }
    }
}
