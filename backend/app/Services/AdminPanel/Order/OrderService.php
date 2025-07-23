<?php

namespace App\Services\AdminPanel\Order;

use App\Models\Delivery;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class OrderService
{
    protected $orderSearchService;
    public function __construct(OrderSearchService $orderSearchService)
    {
        $this->orderSearchService = $orderSearchService;
    }

    public function getPaginatedOrders(int $perPage)
    {
        return Order::paginate($perPage);
    }

    public function getHeaderInfo()
    {
        $ordersHeader['count'] = Order::all()->count();
        $ordersHeader['the_most_expensive'] = Order::orderByDesc('total_price')->first();
        $ordersHeader['the_largest'] = Order::withCount('positions')
            ->orderByDesc('positions_count')
            ->first();

        $totalOrders = Order::count();
        $deliveredOrders = Order::where('status', 'delivered')->count();
        $ordersHeader['finishedOrdersProcent'] = $totalOrders > 0
            ? round(($deliveredOrders / $totalOrders) * 100, 2)
            : 0;


        return $ordersHeader;
    }

    public function indexWithFilters($filters)
    {
        return $this->orderSearchService->searchOrders($filters);
    }

    public function destroy(Order $order): void
    {
        try {
            DB::beginTransaction();

            $orderPositions = $order->positions->filter(fn($item) => $item->type === 'product');

            foreach ($orderPositions as $orderPosition) {
                $productDb = Product::find($orderPosition->product_id);

                if (!$productDb) {
                    throw new \DomainException("Product not found: ID {$orderPosition->product_id}");
                }

                $productDb->increment('count', $orderPosition->quantity);
            }

            $order->delete();

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            logger()->error('Ошибка удаления заказа', ['order_id' => $order->id, 'exception' => $th]);
            throw $th; // Пробрасываем исключение для дальнейшей обработки
        }
    }

    public function getTotalPrice(Order $order)
    {
        if ($order->positions->every(fn($position) => $position->calculated == 1)) {
            return $order->positions->sum(fn($position) => $position->unit_price * $position->quantity);
        } else {
            return null;
        }
    }

    public function updateDeliveryPrice($order)
    {
        $totalWeight = 0;
        foreach ($order->positions as $position) {
            $totalWeight += $position->weight * $position->quantity;
        }

        $delivery = $order->positions->firstWhere('type', 'delivery');
        $delivery->update([
            'unit_price' => $totalWeight * Delivery::getDefault()->price_per_kg,
        ]);
    }

    public function hasLinkPosition(Order $order)
    {
        if ($order->positions->contains(fn($position) => $position->type == 'link')) {
            return true;
        } else {
            return false;
        }
    }
}
