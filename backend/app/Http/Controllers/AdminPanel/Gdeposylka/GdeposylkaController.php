<?php

namespace App\Http\Controllers\AdminPanel\Gdeposylka;

use App\Http\Controllers\Controller;
use App\Services\AdminPanel\Order\DeliveryStatus\GdePosylka\GdeposylkaService;
use App\Services\AdminPanel\Order\DeliveryStatus\GdePosylka\MockGdeposylkaService;
use Exception;

    class GdeposylkaController extends Controller
{
    public function __construct(protected GdeposylkaService $service, protected MockGdeposylkaService $mockService)
    {
    }

    public function index()
    {
        return response()->json([
            'data' => config('services.gdeposylka.mock')
                ? $this->mockService->listCouriers()
                : $this->service->listCouriers(),
        ]);
    }

    public function detect(string $trackingNumber)
    {
        return response()->json([
            'data' => config('services.gdeposylka.mock')
                ? $this->mockService->detectCourier($trackingNumber)
                : $this->service->detectCourier($trackingNumber),
        ]);
    }

    public function track(string $trackingNumber)
    {
        return response()->json([
            'data' => config('services.gdeposylka.mock')
                ? $this->mockService->getTracking($trackingNumber)
                : $this->service->getTracking($trackingNumber),
        ]);
    }

    public function fetch(string $trackingNumber)
    {
        if (config('services.gdeposylka.mock')) {
            return response()->json(['data' => $this->mockService->fetchTracking($trackingNumber)]);
        }

        try {
            $data = $this->service->fetchTracking($trackingNumber);
            return response()->json(['data' => $data]);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'waiting',
                'message' => $e->getMessage(),
            ], 202);
        }
    }
}
