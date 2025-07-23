<?php

namespace App\Http\Resources\Order\Delivery;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderDeliveryStatusResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'tracking_number' => $this->trackink_number,
            'carrier' => $this->carrier,
            'latest_status' => $this->latest_status,
            'last_checked_at' => $this->last_checked_at->translatedFormat('j F Yг. в H:i'),
            'events' => OrderDeliveryEventResource::collection($this->events),
        ];
    }
}
