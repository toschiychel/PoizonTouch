<?php

namespace App\Http\Controllers;

use App\Services\AdminPanel\Order\DeliveryStatus\GdePosylka\GdeposylkaService;
use Illuminate\Http\Request;

class GdePosController extends Controller
{
    protected $service;

    public function __construct(GdeposylkaService $service) {
        $this->service = $service;
    }

    public function __invoke(Request $request)
    {
        $tracking = '10105129034';
        $response = $this->service->getTracking($tracking);
        dd($response);
    }
}
