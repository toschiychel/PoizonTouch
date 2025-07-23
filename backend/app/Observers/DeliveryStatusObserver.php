<?php

namespace App\Observers;

use App\Events\Order\DeliveryStatusDelivered;
use App\Models\DeliveryStatus;

class DeliveryStatusObserver
{
        public function updated(DeliveryStatus $status): void
    {
        if (!$status->wasChanged('latest_status')) {
            return;
        }

        $new = $status->latest_status;
        $keywords = ['delivered', 'вручение', 'доставлено', 'single'];

        if (in_array(mb_strtolower($new), $keywords, true)) {
            event(new DeliveryStatusDelivered($status));
        }
    }
}
