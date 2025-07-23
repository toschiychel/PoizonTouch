<?php

namespace App\Http\Controllers\AdminPanel\Order;

use App\Http\Controllers\BaseController\AdminPanel\BaseOrderController;
use App\Models\Order;

class ShowController extends BaseOrderController
{
    public function __invoke(Order $order)
    {
        return view('order.show', [
            'order' => $this->orderDTOService->getOrderData($order),
            'statuses' => $this->orderDTOService->getStatuses(),
            'header' => $this->service->getHeaderInfo(),
            'hasLinkPosition' => $this->service->hasLinkPosition($order),
        ]);
    }
}
