<?php

namespace App\Http\Resources\Order\Delivery;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderDeliveryEventResource extends JsonResource
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
            'status' => $this->status,
            'description' => $this->description,
            'location' => $this->location,
            'happened_at' => $this->happened_at->translatedFormat('j F Yг. в H:i'),
        ];
    }
}
