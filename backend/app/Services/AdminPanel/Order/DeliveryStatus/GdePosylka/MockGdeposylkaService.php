<?php

namespace App\Services\AdminPanel\Order\DeliveryStatus\GdePosylka;

class MockGdeposylkaService implements GdeposylkaContract
{
    public function listCouriers()
    {
        return [
            ['slug' => 'russian-post', 'name' => 'Почта России', 'country_code' => 'RUS'],
            ['slug' => 'china-post', 'name' => 'Почта Китая', 'country_code' => 'CHN'],
        ];
    }

    public function detectCourier(string $trackingNumber)
    {
        return [[
            'tracking_number' => strtoupper($trackingNumber),
            'courier' => ['slug' => 'russian-post', 'name' => 'Почта России', 'country_code' => 'RUS'],
            'tracker_url' => ''
        ]];
    }

    public function getTracking(string $trackingNumber)
    {
        return [
            'id' => 1,
            'tracking_number' => strtoupper($trackingNumber),
            'courier' => ['slug' => 'russian-post', 'name' => 'Почта России', 'country_code' => 'RUS'],
            'is_active' => false,
            'is_delivered' => true,
            'last_check' => now()->format('Y-m-d H:i:s'),
            'checkpoints' => [
                ['time' => '2025-05-25 04:00:00', 'status_code' => 'accepted', 'status_name' => 'Принято в обработку', 'location_translated' => 'Москва'],
                ['time' => '2025-06-25 04:00:00', 'status_code' => 'accepted', 'status_name' => 'В пути', 'location_translated' => 'Новосибирск'],
                ['time' => '2025-07-25 04:00:00', 'status_code' => 'delivered', 'status_name' => 'Доставлено', 'location_translated' => 'Получатель']
            ],
            'extra' => []
        ];
    }

        public function fetchTracking(string $trackingNumber)
    {
        $result = $this->getTracking($trackingNumber);

        return $result;
    }
}
