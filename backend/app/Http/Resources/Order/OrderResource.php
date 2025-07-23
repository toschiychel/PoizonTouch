<?php

namespace App\Http\Resources\Order;

use App\Http\Resources\Order\Delivery\OrderDeliveryStatusResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'user_id' => $this->user_id,
            'total_price' => $this->total_price,
            'status' => $this->status->label(),
            'positions' => OrderPositionResource::collection($this->whenLoaded('positions')),
            'created_at' => $this->created_at->translatedFormat('j F Yг. в H:i'),
            'contacts' => new OrderContactResource($this->contact),
            'delivery' => $this->deliveryStatus ? new OrderDeliveryStatusResource($this->deliveryStatus) : null,
        ];
    }
}
