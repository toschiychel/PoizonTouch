<?php

namespace App\Services\Api\YooKassa;

use App\Enums\OrderStatus;
use App\Models\Order;
use YooKassa\Client;

class YooKassaService
{
    public function __construct(
        protected Client $client
    ) {}

    public function createPayment(Order $order)
    {
        if ($order->status != OrderStatus::PendingPayment) {
            throw new \DomainException("Заказ №{$order->id} не готов к оплате");
        }
        if ($order->total_price === null || $order->total_price <= 0) {
            throw new \DomainException("Некорректная сумма для заказа №{$order->id}");
        }

        $payment = $this->client->createPayment(
            [
                'amount'       => [
                    'value'    => $order->total_price,
                    'currency' => 'RUB',
                ],
                'confirmation' => [
                    'type'       => 'redirect',
                    'return_url' => config('app.frontend_url') . '/account/orders',
                ],
                'capture'      => true,
                'description'  => 'Оплата заказа №' . $order->id,
                'metadata'     => [
                    'order_id' => $order->id,
                ],
            ],
            uniqid('', true)
        );

        $order->update([
            'status' => OrderStatus::Processing
        ]);

        return [
            'payment_id' => $payment->getId(),
            'confirmationUrl' => $payment->getConfirmation()->getConfirmationUrl(),
            'status' => $payment->getStatus(),
        ];
    }
}
