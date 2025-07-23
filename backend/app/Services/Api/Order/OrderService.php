<?php

namespace App\Services\Api\Order;

use App\Enums\OrderStatus;
use App\Events\Order\OrderCreated;
use App\Http\Resources\Order\OrderResource;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Delivery;
use App\Services\AdminPanel\Order\OrderCalculationService;
use DomainException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderService
{
    public function store($data, User $user)
    {
        try {
            DB::beginTransaction();

            $products = array_filter($data['products'], function ($item) {
                return isset($item['type']) && $item['type'] === 'product';
            });
            $links = array_filter($data['products'], function ($item) {
                return isset($item['type']) && $item['type'] === 'link';
            });

            $hasUnpricedItems = !empty($links);
            $order = Order::create([
                'user_id' => $user->id,
                'total_price' => 0,
                'status' => $hasUnpricedItems ? OrderStatus::AwaitingPriceCalculation : OrderStatus::PendingPayment,
            ]);

            foreach ($links as $link) {
                $order->positions()->create([
                    'order_id' => $order->id,
                    'type' => $link['type'],
                    'title' => $link['title'],
                    'link_url' => $link['link_url'],
                    'weight' => $link['weight'],
                    'price_cny' => $link['price_cny'],
                    'quantity' => $link['quantity'],
                    'calculated' => false,
                    'preview_image_path' => 'products/poizon-default.jpeg'
                ]);
            }

            foreach ($products as $product) {
                $productDB = Product::find($product['id']);
                if ($productDB->count < $product['quantity']) {
                    throw new DomainException("Недостаточно товара: {$product['title']} ");
                }
                $productDB->decrement('count', $product['quantity']);
                $product['weight'] = $productDB->weight;

                $order->positions()->create([
                    'order_id' => $order->id,
                    'product_id' => $product['id'],
                    'type' => $product['type'],
                    'title' => $product['title'],
                    'weight' => $product['weight'],
                    'calculated' => true,
                    'quantity' => $product['quantity'],
                    'unit_price' => isset($product['price']) ? $product['price'] : null,
                    'preview_image_path' => str_replace(url('/storage/') . '/', '', $product['preview_image']),
                ]);
            }

            $totalWeight = 0;
            foreach ($order->positions as $position) {
                $totalWeight += $position->weight * $position->quantity;
            }

            $delivery = $order->positions()->create([
                'order_id' => $order->id,
                'type'       => 'delivery',
                'title'       => 'Доставка',
                'preview_image_path' => 'products/delivery.jpg',
                'unit_price' => $totalWeight * Delivery::getDefault()->price_per_kg,
                'quantity'   => 1,
            ]);


            $order->contact()->create([
                'order_id' => $order->id,
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'phone' => $data['phone'],
                'email' => $data['email'],
                'address' => $data['address'],
                'note' => $data['note'] ?? null,
            ]);

            DB::commit();

            $order->refresh();
            app(OrderCalculationService::class)->calculate($order);

            event(new OrderCreated($order));

            return new OrderResource($order);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::warning($th->getMessage() . ' at line ' . $th->getLine());

            throw $th;
        }
    }
}
