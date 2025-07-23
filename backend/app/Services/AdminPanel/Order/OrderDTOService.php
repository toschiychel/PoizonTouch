<?php

namespace App\Services\AdminPanel\Order;

use App\DTO\OrderDTO;
use App\DTO\OrderContactDTO;
use App\DTO\OrderDeliveryEventDTO;
use App\DTO\OrderDeliveryStatusDTO;
use App\DTO\OrderPositionDTO;
use App\DTO\UserDTO;
use App\Enums\OrderStatus;
use App\Models\Order;

class OrderDTOService
{
    public function getOrderData(Order $order)
    {
        return new OrderDTO(
            id: $order->id,
            orderNumber: $order->id,
            totalPrice: number_format($order->total_price, 0, ',', ' '),
            createdAt: $order->created_at->translatedFormat('j F Yг. в H:i'),
            user: $this->makeUserDTO($order),
            contacts: $this->makeContactDTO($order),
            status: $this->getStatusLabel($order),
            positions: $this->makePositionsDTO($order),
            calculated: $order->calculated,
            deliveryInfo: $this->makeDeliveryStatusDTO($order)
        );
    }

    public function getStatuses()
    {
        return OrderStatus::labels();
    }

    public function getOrderPositionsForPriceChanging(Order $order)
    {
        $positions = $this->makePositionsDTO($order);
        $linkPositions = array_filter($positions, fn($position) => $position->type === 'link');
        return $linkPositions;
    }

    private function makeUserDTO(Order $order)
    {
        $user = $order->user;

        return new UserDTO(
            id: $user->id,
            name: $user->name,
            email: $user->email,
        );
    }

    private function makeContactDTO(Order $order)
    {
        $contact = $order->contact;

        return new OrderContactDTO(
            first_name: $contact->first_name,
            last_name: $contact->last_name,
            phone: $contact->phone,
            email: $contact->email,
            address: $contact->address,
            note: $contact->note,
        );
    }

    /**
     * @return OrderPositionDTO[]
     */
    private function makePositionsDTO(Order $order)
    {
        return $order->positions->map(fn($positions) => new OrderPositionDTO(
            id: $positions->id,
            title: $positions->title,
            type: $positions->type,
            linkUrl: $positions->link_url,
            convertedPriceRub: $positions->converted_price_rub,
            priceCny: $positions->price_cny,
            weight: $positions->weight,
            quantity: $positions->quantity,
            unitPrice: $positions->unit_price,
            previewImage: $positions->preview_image_path,
            isCalculated: $positions->calculated
        ))->toArray();
    }

    private function getStatusLabel(Order $order)
    {
        return $order->status->label();
    }

    private function makeDeliveryStatusDTO(Order $order)
    {
        
        if(!$order->deliveryStatus) {
            return null;
        }

        $deliveryStatus = $order->deliveryStatus;
        
        return new OrderDeliveryStatusDTO(
            id: $deliveryStatus->id,
            trackingNumber: $deliveryStatus->tracking_number,
            carrier: $deliveryStatus->carrier,
            latestStatus: $deliveryStatus->latest_status,
            lastCheckedAt: $deliveryStatus->last_checked_at->translatedFormat('j F Yг. в H:i'),
            events: $this->makeEventsDTO($order)
        );
    }

    private function makeEventsDTO(Order $order)
    {
        return $order->deliveryStatus->events->map(fn($events) => new OrderDeliveryEventDTO(
            id: $events->id,
            status: $events->status,
            description: $events->description,
            location: $events->location,
            happenedAt: $events->happened_at->translatedFormat('j F Yг. в H:i'),
        ))->toArray();
    }
}
