<?php

namespace App\Http\Controllers\Api\YooKassa;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\Api\YooKassa\YooKassaService;
use Illuminate\Support\Facades\Log;

class CreatePaymentController extends Controller
{
    public function createPayment(Order $order, YooKassaService $yooService)
    {
        try {
            $data = $yooService->createPayment($order);
            return response()->json($data, 201);
        } catch (\DomainException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        } catch (\Throwable $e) {
            Log::error('YooKassa error on createPayment', [
                'order_id' => $order->id,
                'exception' => $e,
            ]);
            return response()->json([
                'error' => 'Не удалось создать платёж'
            ], 500);
        }
    }
}
