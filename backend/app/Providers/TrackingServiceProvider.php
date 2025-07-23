<?php

namespace App\Providers;

use App\Services\AdminPanel\Order\DeliveryStatus\GdePosylka\GdePosylkaAdapter;
use App\Services\AdminPanel\Order\DeliveryStatus\GdePosylka\GdeposylkaService;
use App\Services\AdminPanel\Order\DeliveryStatus\GdePosylka\RussianPost\RussianPostService;
use App\Services\AdminPanel\Order\DeliveryStatus\TrackingServiceFactory;
use App\Services\AdminPanel\Order\DeliveryStatus\TrackingServiceFactoryImpl;
use App\Services\AdminPanel\Order\DeliveryStatus\TrackingServiceInterface;
use Illuminate\Support\ServiceProvider;

class TrackingServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Контракт GdePosylkaContract зарегистрирован отдельно
        $this->app->bind(TrackingServiceInterface::class, function($app) {
            // Не используется напрямую
            return $app->make(TrackingServiceFactory::class)->make('');
        });

        $this->app->bind(GdePosylkaAdapter::class, function($app) {
            return new GdePosylkaAdapter($app->make(GdeposylkaService::class));
        });

        $this->app->singleton(RussianPostService::class);

        $this->app->singleton(TrackingServiceFactory::class, function($app) {
            return new TrackingServiceFactoryImpl(
                $app->make(GdePosylkaAdapter::class),
                $app->make(RussianPostService::class)
            );
        });
    }

    public function boot() {}
}
