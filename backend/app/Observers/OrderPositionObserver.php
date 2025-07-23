<?php

namespace App\Observers;

use App\Models\OrderPosition;

class OrderPositionObserver
{
    /**
     * Handle the OrderPosition "created" event.
     */
    public function created(OrderPosition $position): void
    {
        //
    }

    /**
     * Handle the OrderPosition "updated" event.
     */
    public function updated(OrderPosition $position): void
    {
        if (!$position->wasChanged('calculated')) {
            return;
        }

        $order = $position->order;

        $allCalculated = $order->positions->every(fn($pos) => $pos->calculated);
        
        if($allCalculated) {
            $totalPrice = 0;
            foreach ($order->positions as $orderPosition) {
                $totalPrice += $orderPosition->unit_price * $orderPosition->quantity;
            }

            $order->update([
                'total_price' => $totalPrice
            ]);
        }

        $order->update([
            'calculated' => $allCalculated,
        ]);

    }

    /**
     * Handle the OrderPosition "deleted" event.
     */
    public function deleted(OrderPosition $position): void
    {
        //
    }

    /**
     * Handle the OrderPosition "restored" event.
     */
    public function restored(OrderPosition $position): void
    {
        //
    }

    /**
     * Handle the OrderPosition "force deleted" event.
     */
    public function forceDeleted(OrderPosition $position): void
    {
        //
    }
}
