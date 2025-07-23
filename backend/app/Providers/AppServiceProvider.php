<?php

namespace App\Providers;

use App\Enums\UserRole;
use App\Events\Order\DeliveryStatusDelivered;
use App\Events\Order\OrderCreated;
use App\Events\Order\StatusUpdated;
use App\Listeners\Admin\Order\NotifyOfNewOrder;
use App\Models\DeliveryStatus;
use App\Models\Order;
use App\Models\OrderPosition;
use App\Models\User;
use App\Notifications\Admin\OrderStatusUpdatedNotification as AdminNotif;
use App\Notifications\User\OrderStatusUpdatedNotification as UserNotif;
use App\Notifications\User\ParcelDeliveredNotification;
use App\Observers\DeliveryStatusObserver;
use App\Observers\OrderObserver;
use App\Observers\OrderPositionObserver;
use App\Services\AdminPanel\Order\DeliveryStatus\GdePosylka\GdeposylkaContract;
use App\Services\AdminPanel\Order\DeliveryStatus\GdePosylka\GdeposylkaService;
use App\Services\AdminPanel\Order\DeliveryStatus\GdePosylka\MockGdeposylkaService;
use App\Services\AdminPanel\Order\OrderDTOService;
use App\Services\AdminPanel\Telegram\QrCode\QrCodeLaravelService;
use App\Services\AdminPanel\Telegram\QrCode\QrCodeServiceInterface;
use App\Services\AdminPanel\Telegram\TelegramChannel;
use Carbon\Carbon;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\ChannelManager;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\ServiceProvider;
use YooKassa\Client;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(OrderDTOService::class, function ($app) {
            return new OrderDTOService();
        });

        $this->app->bind(
            GdeposylkaContract::class,
            fn($app) => config('services.gdeposylka.mock')
                ? $app->make(MockGdeposylkaService::class)
                : $app->make(GdeposylkaService::class)
        );

        $this->app->singleton(Client::class, function ($app) {
            $cfg = config('services.yookassa');
            $client = new Client();
            $client->setAuth($cfg['shop_id'], $cfg['secret_key']);
            return $client;
        });

        $this->app->bind(QrCodeServiceInterface::class, QrCodeLaravelService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Password reset link for SPA
        ResetPassword::createUrlUsing(function (object $notifiable, string $token) {
            return config('app.frontend_url')
                . "/password-reset/{$token}?email={$notifiable->getEmailForPasswordReset()}";
        });

        // Локализация Carbon
        Carbon::setLocale('ru');

        // Model observers
        OrderPosition::observe(OrderPositionObserver::class);
        Order::observe(OrderObserver::class);
        DeliveryStatus::observe(DeliveryStatusObserver::class);

        // Telegram notification channel
        $this->app->make(ChannelManager::class)
            ->extend('telegram', fn($app) => $app->make(TelegramChannel::class));

        Event::listen(StatusUpdated::class, function (StatusUpdated $event) {
            // Пользовательское уведомление
            $event->order
                ->user
                ->notify(new UserNotif(
                    $event->order,
                    $event->oldStatus,
                    $event->newStatus
                ));
        });

        Event::listen(DeliveryStatusDelivered::class, function (DeliveryStatusDelivered $event) {
            $event->deliveryStatus
                ->order
                ->user
                ->notify(new ParcelDeliveredNotification(
                    $event->deliveryStatus->order,
                    $event->deliveryStatus
                ));
        });
    }
}
