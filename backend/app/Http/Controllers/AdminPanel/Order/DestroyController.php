<?php

namespace App\Http\Controllers\AdminPanel\Order;

use App\Http\Controllers\BaseController\AdminPanel\BaseOrderController;
use App\Models\Order;

class DestroyController extends BaseOrderController
{
    public function __invoke(Order $order)
    {
        try {
            $this->service->destroy($order);
            return redirect()->route('order.index')->with('success', 'Заказ успешно удалён');
        } catch (\Throwable $e) {
            return redirect()->route('order.index')->with('error', 'Ошибка при удалении заказа.');
        }
    }
}
