<?php

namespace App\Http\Controllers\AdminPanel\Order\Position;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminPanel\Order\Position\UpdateRequest as PositionUpdateRequest;
use App\Models\Order;
use App\Models\OrderPosition;
use App\Services\AdminPanel\Currency\CurrencyRateService;
use App\Services\AdminPanel\Order\OrderDeliveryService;
use App\Services\AdminPanel\Order\OrderService;
use Illuminate\Support\Facades\DB;

class UpdateController extends Controller
{
    protected $currencyService;
    protected $orderService;
    protected $orderDelivery;
    public function __construct(CurrencyRateService $currencyService, OrderService $orderService, OrderDeliveryService $orderDelivery) {
        $this->currencyService = $currencyService;
        $this->orderService = $orderService;
        $this->orderDelivery = $orderDelivery;
    }
    
    public function __invoke(PositionUpdateRequest $request, Order $order)
    {
        
        try {
            DB::beginTransaction();
            $data = $request->validated();

            $cnyRubRate = $this->currencyService->getActualRate(true);
            foreach ($data['linkPositions'] as $position) {
                $positionForUpdate = OrderPosition::find($position['id']);

                $priceWithCommission = $this->priceCalculate($position, $cnyRubRate);

                $positionForUpdate->update([
                    'title' => $position['title'],
                    'weight' => $position['weight'],
                    'unit_price' => $priceWithCommission,
                    'calculated' => 1
                ]);
            }

            $this->orderDelivery->calculate($order);

            $order->update([
                'total_price' => $this->orderService->getTotalPrice($order)
            ]);

            DB::commit();

        } catch (\Throwable $th) {
            DB::rollBack();
            logger()->error('Ошибка обновления позиции', ['order_id' => $order->id, 'exception' => $th]);
            throw $th;
        }

        return redirect()->route('order.edit', $order->id);
    }

    private function priceCalculate($position, $rate) {
        $convertedPriceToRub = $position['cny_price'] * $rate;

                if (!empty($position['commission_percent'])) {
                    $commission = 1 + ($position['commission_percent'] / 100);
                    $priceWithCommission = $convertedPriceToRub * $commission;
                    return (int) $priceWithCommission;
                }
                if (!empty($position['commission_fixed'])) {
                    $priceWithCommission = $convertedPriceToRub + $position['commission_fixed'];
                    return (int) $priceWithCommission;
                }
    }
}
