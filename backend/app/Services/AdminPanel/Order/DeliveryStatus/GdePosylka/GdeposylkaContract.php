<?php

namespace App\Services\AdminPanel\Order\DeliveryStatus\GdePosylka;

interface GdeposylkaContract
{
    public function listCouriers();
    public function detectCourier(string $trackingNumber);
    public function getTracking(string $trackingNumber);
    public function fetchTracking(string $trackingNumber);
}
