<?php

namespace App\Services\AdminPanel\Order;

use App\Models\Order;
use Illuminate\Support\Str;

class OrderSearchService
{
    // Константы фильтров
    const FILTER_ORDER_ID = 'order_id';
    const FILTER_ORDER_STATUS = 'order_status';
    const FILTER_USER_EMAIL = 'email';

    /**
     * Поиск заказов с фильтрами.
     *
     * @param array $filters
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function searchOrders(array $filters)
    {
        $query = Order::query();

        // Применяем фильтры динамически
        foreach ($filters as $filter => $value) {
            $method = 'filterBy' . Str::studly($filter); // Преобразует order_id → OrderId
            if ($value && method_exists($this, $method)) {
                $query = $this->$method($query, $value);
            }
        }

        // Сортировка по дате
        return $query->orderBy('created_at', 'desc')->paginate(10);
    }

    /**
     * Фильтр по ID заказа.
     *
     * @param $query
     * @param $value
     * @return mixed
     */
    protected function filterByOrderId($query, $value)
    {
        return $query->where('id', $value);
    }

    /**
     * Фильтр по статусу заказа.
     *
     * @param $query
     * @param $value
     * @return mixed
     */
    protected function filterByOrderStatus($query, $value)
    {
        return $query->where('status', $value);
    }

    /**
     * Фильтр по пользователю.
     *
     * @param $query
     * @param $value
     * @return mixed
     */
    protected function filterByEmail($query, $value)
    {
        return $query->whereHas('user', function ($query) use ($value) {
            $query->where('email', $value);
        });
    }
}