<?php

namespace App\Services\AdminPanel\Order\DeliveryStatus;

interface TrackingServiceFactory
{
    public function make(string $trackingNumber);
}
