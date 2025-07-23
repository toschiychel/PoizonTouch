<?php

namespace App\Http\Controllers\Api\Order;

use App\Http\Controllers\BaseController\Api\BaseOrderController;
use App\Http\Requests\Api\Order\StoreRequest;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class StoreController extends BaseOrderController
{
    public function __invoke(StoreRequest $request, User $user)
    {
        try {
            $orderResource = $this->service->store($request->validated(), $user);
            return response()->json($orderResource, 201);
        } catch (\DomainException $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        } catch (\Throwable $e) {
            Log::error('Ошибка при создании заказа', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => $user->id,
            ]);

            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
