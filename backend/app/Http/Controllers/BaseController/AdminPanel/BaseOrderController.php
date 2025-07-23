<?php

namespace App\Http\Controllers\BaseController\AdminPanel;

use App\Http\Controllers\Controller;
use App\Services\AdminPanel\Order\OrderCalculationService;
use App\Services\AdminPanel\Order\OrderDTOService;
use App\Services\AdminPanel\Order\OrderSearchService;
use App\Services\AdminPanel\Order\OrderService;

class BaseOrderController extends Controller
{
    protected $service;
    protected $orderDTOService;
    protected $orderSearchService;
    protected $orderCalculationService;

    public function __construct(OrderService $service, OrderDTOService $orderDTOService, OrderSearchService $orderSearchService, OrderCalculationService $orderCalculationService) {
        $this->service = $service;
        $this->orderDTOService = $orderDTOService;
        $this->orderSearchService = $orderSearchService;
        $this->orderCalculationService = $orderCalculationService;
    }
}
