<?php

namespace App\Http\Controllers\AdminPanel\Order\DeliveryStatus;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminPanel\Order\DeliveryStatus\StoreRequest;
use App\Models\Order;
use App\Services\AdminPanel\Order\DeliveryStatus\OrderDeliveryStatusService;

class StoreController extends Controller
{
    protected $service;
    public function __construct(OrderDeliveryStatusService $service) {
        $this->service = $service;
    }
    
    public function __invoke(StoreRequest $request, Order $order)
    {
        $data = $request->validated();
        $this->service->register($order, $data['trackingNumber']);

        return redirect()->route('order.show', $order->id);
    }
}
