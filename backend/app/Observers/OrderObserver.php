<?php

namespace App\Observers;

use App\Enums\OrderStatus;
use App\Events\Order\StatusUpdated;
use App\Models\Order;
use Illuminate\Support\Facades\Log;

class OrderObserver
{
    /**
     * Handle the Order "created" event.
     */
    public function created(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "updated" event.
     */
    public function updated(Order $order): void
    {
        if ($order->wasChanged('status')) {
            Log::info('OrderObserver: статус изменился', [
                'order_id'   => $order->id,
                'old_status' => $order->getOriginal('status'),
                'new_status' => $order->status->value,
            ]);

            $old = OrderStatus::from($order->getOriginal('status')->value)->label();
            $new = $order->status->label();

            event(new StatusUpdated($order, (string)$old, (string)$new));
        }
    }

    /**
     * Handle the Order "deleted" event.
     */
    public function deleted(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "restored" event.
     */
    public function restored(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "force deleted" event.
     */
    public function forceDeleted(Order $order): void
    {
        //
    }
}
