<?php

namespace App\Services\AdminPanel\Order\DeliveryStatus;

use App\Enums\OrderStatus;
use App\Exceptions\TrackingNotSupportedException;
use App\Models\DeliveryEvent;
use App\Models\DeliveryStatus;
use App\Models\Order;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderDeliveryStatusService
{
    public function __construct(protected TrackingServiceFactory $factory) {}

    public function register(Order $order, string $trackingNumber)
    {
        DB::beginTransaction();
        $status = DeliveryStatus::updateOrCreate(
            ['order_id' => $order->id],
            ['tracking_number' => $trackingNumber, 'carrier' => 'unknown', 'last_checked_at' => now()]
        );

        try {
            $service = $this->factory->make($trackingNumber);
            $response = $service->track($trackingNumber);

            $status->update(['carrier' => $response['courier']['name']]);
        } catch (TrackingNotSupportedException $e) {
            Log::warning('Tracking unsupported', ['number' => $trackingNumber]);
            $this->syncEvents($status, []);
            $order->update(['status' => OrderStatus::Shipped]);
            DB::commit();
            return $status;
        } catch (\Exception $e) {
            Log::error('Tracking error', ['number' => $trackingNumber, 'e' => $e->getMessage()]);
            DB::rollBack();
            throw $e;
        }

        $order->update(['status' => OrderStatus::Shipped]);
        $this->syncEvents($status, $response['checkpoints']);
        DB::commit();

        return $status;
    }

    public function refreshAllPending()
    {
        DeliveryStatus::whereNotIn('latest_status', ['delivered', 'вручение', 'доставлено', 'single'])
            ->chunk(100, function ($statuses) {
                foreach ($statuses as $status) {


                    $tn = $status->tracking_number;
                    try {
                        $service  = $this->factory->make($tn);
                        $response = $service->track($tn);

                        if ($status->carrier == 'unknown') {
                            Log::alert('blabla');
                            $status->update(['carrier' => $response['courier']['name']]);
                            $status->save();
                        }
                    } catch (TrackingNotSupportedException $e) {
                        continue;
                    } catch (\Exception $e) {
                        Log::error('Tracking error', ['number' => $tn, 'e' => $e->getMessage()]);
                        continue;
                    }

                    $this->syncEvents($status, $response['checkpoints']);
                }
            });
    }

    protected function syncEvents(DeliveryStatus $status, array $events)
    {
        if (empty($events)) {
            DeliveryEvent::firstOrCreate([
                'delivery_status_id' => $status->id,
                'status' => 'pending'
            ], [
                'happened_at' => now(),
                'description' => 'Ожидание первого статуса',
                'location' => null
            ]);
            $status->update(['latest_status' => 'pending', 'last_checked_at' => now()]);
            return;
        }

        $delivered = false;
        foreach ($events as $event) {
            DeliveryEvent::updateOrCreate([
                'delivery_status_id' => $status->id,
                'status' => $event['status_code'],
                'happened_at' => Carbon::parse($event['time']),
            ], [
                'description' => $event['status_name'],
                'location' => $event['location_translated'] ?? null
            ]);

            if ($event['status_code'] === 'arrived_pickup') {
                $delivered = true;
            }
        }

        $last = reset($events);
        $status->update(['latest_status' => $last['status_code'], 'last_checked_at' => now()]);

        if ($delivered) {
            $status->order->update(['status' => OrderStatus::Delivered]);
        }
    }
}
