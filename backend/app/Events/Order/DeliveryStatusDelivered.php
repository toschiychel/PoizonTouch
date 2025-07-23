<?php

namespace App\Events\Order;

use App\Models\DeliveryStatus;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DeliveryStatusDelivered
{
    use Dispatchable, SerializesModels;

    public DeliveryStatus $deliveryStatus;

    public function __construct(DeliveryStatus $deliveryStatus)
    {
        $this->deliveryStatus = $deliveryStatus;
    }
}
