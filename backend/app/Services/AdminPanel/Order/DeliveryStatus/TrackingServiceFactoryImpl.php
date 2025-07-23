<?php

namespace App\Services\AdminPanel\Order\DeliveryStatus;

use App\Services\AdminPanel\Order\DeliveryStatus\GdePosylka\GdePosylkaAdapter;
use App\Services\AdminPanel\Order\DeliveryStatus\GdePosylka\RussianPost\RussianPostService;

class TrackingServiceFactoryImpl implements TrackingServiceFactory
{
    public function __construct(
        protected GdePosylkaAdapter $gde,
        protected RussianPostService $ru
    ) {}

    public function make(string $trackingNumber)
{
    try {
        $detected = $this->gde->detectCourier($trackingNumber);
        $slug = $detected[0]['courier']['slug'] ?? null;

        if (in_array($slug, ['russian-post', 'pochta-rossii'], true)) {
            return $this->ru;
        }
    } catch (\Exception $e) {
    }

    return $this->gde;
}
}
