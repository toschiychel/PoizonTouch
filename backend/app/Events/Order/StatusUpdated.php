<?php

namespace App\Events\Order;

use App\Models\Order;
use App\Notifications\Admin\OrderStatusUpdatedNotification as AdminOrderStatusUpdatedNotification;
use App\Notifications\User\OrderStatusUpdatedNotification;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Support\Facades\Notification;

class StatusUpdated
{
     use Dispatchable;

    public Order $order;
    public string $oldStatus;
    public string $newStatus;

    public function __construct(Order $order, string $oldStatus, string $newStatus)
    {
        $this->order = $order;
        $this->oldStatus = $oldStatus;
        $this->newStatus = $newStatus;
    }
}
