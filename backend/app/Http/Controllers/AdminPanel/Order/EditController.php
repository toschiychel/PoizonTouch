<?php

namespace App\Http\Controllers\AdminPanel\Order;

use App\Http\Controllers\BaseController\AdminPanel\BaseOrderController;
use App\Models\Order;

class EditController extends BaseOrderController
{
    public function __invoke(Order $order)
    {
        return view('order.edit', [
            'linkPositions' => $this->orderDTOService->getOrderPositionsForPriceChanging($order),
            'order' => $this->orderDTOService->getOrderData($order),
            'header' => $this->service->getHeaderInfo(),
        ]);
    }
}
