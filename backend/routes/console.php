<?php

use App\Services\AdminPanel\Order\DeliveryStatus\OrderDeliveryStatusService;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


Artisan::command('delivery:refresh {--force}', function (OrderDeliveryStatusService $service) {
    $this->info('Starting delivery statuses refresh...');
    $service->refreshAllPending();
    $this->info('Delivery statuses refresh completed.');
    Log::info('Delivery statuses refresh completed');
})->describe('Refresh all pending delivery statuses via GdePosylka API');

Schedule::command('delivery:refresh')->hourly();

Schedule::command('telegram:poll')->everyMinute()->withoutOverlapping();


