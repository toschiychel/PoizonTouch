<?php

namespace App\Services\AdminPanel\MainPage;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\OrderPosition;
use App\Models\Product;
use App\Models\User;

class MainPageService
{
    public function getHeaderInfo()
    {
        $monthlyRevenue = Order::where('created_at', '>=', now()->subDays(30))->sum('total_price');

        $totalBuyers = Order::distinct('user_id')->count('user_id');
        $repeatBuyers = Order::select('user_id')
            ->groupBy('user_id')
            ->havingRaw('COUNT(*) > 1')
            ->get()
            ->count();
        $repeatCustomerRate = $totalBuyers > 0
            ? round(($repeatBuyers / $totalBuyers) * 100, 2)
            : 0;

        $unfinishedOrdersCount = Order::whereIn('status', [
            OrderStatus::PendingPayment,
            OrderStatus::AwaitingPriceCalculation
        ])->count();

        $topProductId = OrderPosition::where('type', 'product')
            ->whereNotNull('product_id')
            ->groupBy('product_id')
            ->orderByRaw('COUNT(order_id) DESC')
            ->value('product_id');

        $topProduct = $topProductId
            ? Product::find($topProductId)
            : null;

        $header = [
            'monthlyRevenue' => $monthlyRevenue,
            'repeatCustomerRate' => $repeatCustomerRate,
            'unfinishedOrdersCount' => $unfinishedOrdersCount,
            'topProduct' => $topProduct,
        ];

        return $header;
    }

    public function getSalesData()
    {
        // Сумма продаж и кол-во заказов по дням
        $salesData = Order::selectRaw('
            DATE(created_at) as date,
            SUM(total_price) as total,
            COUNT(*) as count
        ')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $maxValue = $salesData->max('total') ?? 1000;
        $maxScale = ceil($maxValue * 1.1); // запас 10%

        // Кол-во заказов по дням
        $ordersByDay = Order::selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('total', 'date');

        // Кол-во регистраций пользователей по дням
        $userRegistrationsByDay = User::selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('total', 'date');

        return [
            'chartData' => $salesData,
            'ordersByDay' => $ordersByDay,
            'userRegistrationsByDay' => $userRegistrationsByDay,
            'meta' => [
                'maxScale' => $maxScale,
                'period' => now()->subDays(30)->format('Y-m-d') . ' - ' . now()->format('Y-m-d')
            ]
        ];
    }
}
