<?php

namespace App\Http\Controllers\AdminPanel\Order;

use App\Http\Controllers\BaseController\AdminPanel\BaseOrderController;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminPanel\Order\UpdateRequest;
use App\Models\Order;

class UpdateController extends BaseOrderController
{
    public function __invoke(UpdateRequest $request, Order $order)
    {
        $data = $request->validated();
        $order->update($data);

        return redirect()->route('order.show', $order->id);
    }
}
