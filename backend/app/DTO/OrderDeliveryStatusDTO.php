<?php

namespace App\DTO;

class OrderDeliveryStatusDTO
{
    public function __construct(
        public $id,
        public $trackingNumber,
        public $carrier,
        public $latestStatus,
        public $lastCheckedAt,
        public $events
    ) {}
}
