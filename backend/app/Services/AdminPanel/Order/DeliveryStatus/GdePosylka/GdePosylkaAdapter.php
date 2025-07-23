<?php

namespace App\Services\AdminPanel\Order\DeliveryStatus\GdePosylka;

use App\Exceptions\TrackingNotSupportedException;

class GdePosylkaAdapter
{
    public function __construct(protected GdeposylkaContract $client) {}

    public function track(string $trackingNumber): array
    {
        try {
            $data = $this->client->fetchTracking($trackingNumber);
        } catch (\Exception $e) {
            try {
                $data = $this->client->getTracking($trackingNumber);
            } catch (\Exception $ex) {
                throw new TrackingNotSupportedException();
            }
        }

        if (empty($data['checkpoints'] ?? [])) {
            throw new TrackingNotSupportedException();
        }

        return [
            'courier' => ['name' => $data['courier']['name'] ?? 'unknown', 'slug' => $data['courier']['slug'] ?? null],
            'checkpoints' => array_map(fn($cp) => [
                'status_code' => $cp['status_code'],
                'status_name' => $cp['status_name'],
                'time' => $cp['time'],
                'location_translated' => $cp['location_translated'] ?? null,
            ], $data['checkpoints']),
        ];
    }

    public function detectCourier(string $trackingNumber): array
    {
        return $this->client->detectCourier($trackingNumber);
    }
}
