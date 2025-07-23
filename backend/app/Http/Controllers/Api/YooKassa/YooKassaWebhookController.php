<?php

namespace App\Http\Controllers\Api\YooKassa;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use YooKassa\Client;
use YooKassa\Model\Notification\NotificationFactory;
use YooKassa\Model\Notification\NotificationEventType;

class YooKassaWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $body = $request->getContent();
        $data = json_decode($body, true);

        // Инициализируем клиент и авторизуемся
        $client = new Client();
        $client->setAuth(
            config('services.yookassa.shop_id'),
            config('services.yookassa.secret_key')
        );

        try {
            // Парсим уведомление через фабрику
            $factory = new NotificationFactory();
            $notification = $factory->factory($data);
            $event = $notification->getEvent();
            $payment = $notification->getObject();

            if ($event === NotificationEventType::PAYMENT_SUCCEEDED) {
                $orderId = $payment->getMetadata()['order_id'] ?? null;
                if ($orderId && $order = Order::find($orderId)) {
                    $order->update(['status' => OrderStatus::Processing]);
                } else {
                    Log::warning("YooKassa: заказ №{$orderId} не найден");
                }
            }

            return response()->json(['code' => 0], 200);
        } catch (\Throwable $e) {
            Log::error('YooKassa Webhook error: ' . $e->getMessage());
            return response()->json(['code' => 1], 500);
        }
    }
}
