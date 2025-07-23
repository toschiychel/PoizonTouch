<?php

namespace App\Services\AdminPanel\Order\DeliveryStatus;

interface TrackingServiceInterface
{
    public function track(string $trackingNumber);
}
