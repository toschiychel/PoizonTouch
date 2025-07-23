<?php

namespace App\Http\Controllers\AdminPanel\Order;

use App\Enums\OrderStatus;
use App\Http\Controllers\BaseController\AdminPanel\BaseOrderController;
use App\Http\Requests\AdminPanel\Order\SearchRequest;

class IndexController extends BaseOrderController
{
    public function __invoke(SearchRequest $request)
    {
        $filters = $request->validated();

        return view('order.index', [
            'orders' => $this->service->indexWithFilters($filters),
            'header' => $this->service->getHeaderInfo(),
            'orderStatuses' => OrderStatus::labels(),
        ]);
    }
}
