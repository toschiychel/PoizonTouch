<?php

use App\Http\Controllers\Auth\LoginPageController;
use App\Http\Controllers\AdminPanel\Category\DestroyController as CategoryDestroyController;
use App\Http\Controllers\AdminPanel\Category\IndexController as CategoryIndexController;
use App\Http\Controllers\AdminPanel\Category\ShowController as CategoryShowController;
use App\Http\Controllers\AdminPanel\Category\StoreController as CategoryStoreController;
use App\Http\Controllers\AdminPanel\Category\UpdateController as CategoryUpdateController;
use App\Http\Controllers\AdminPanel\Color\DestroyController as ColorDestroyController;
use App\Http\Controllers\AdminPanel\Color\IndexController as ColorIndexController;
use App\Http\Controllers\AdminPanel\Color\ShowController as ColorShowController;
use App\Http\Controllers\AdminPanel\Color\StoreController as ColorStoreController;
use App\Http\Controllers\AdminPanel\Color\UpdateController as ColorUpdateController;
use App\Http\Controllers\AdminPanel\Delivery\DestroyController as DeliveryDestroyController;
use App\Http\Controllers\AdminPanel\Delivery\IndexController as DeliveryIndexController;
use App\Http\Controllers\AdminPanel\Delivery\ShowController as DeliveryShowController;
use App\Http\Controllers\AdminPanel\Delivery\StoreController as DeliveryStoreController;
use App\Http\Controllers\AdminPanel\Delivery\UpdateController as DeliveryUpdateController;
use App\Http\Controllers\AdminPanel\Main\IndexController;
use App\Http\Controllers\AdminPanel\Order\DeliveryStatus\StoreController as DeliveryStatusStoreController;
use App\Http\Controllers\AdminPanel\Order\DestroyController as OrderDestroyController;
use App\Http\Controllers\AdminPanel\Order\EditController as OrderEditController;
use App\Http\Controllers\AdminPanel\Order\IndexController as OrderIndexController;
use App\Http\Controllers\AdminPanel\Order\Position\UpdateController as PositionUpdateController;
use App\Http\Controllers\AdminPanel\Order\ShowController as OrderShowController;
use App\Http\Controllers\AdminPanel\Order\UpdateController as OrderUpdateController;
use App\Http\Controllers\AdminPanel\Product\CreateController as ProductCreateController;
use App\Http\Controllers\AdminPanel\Product\DestroyController as ProductDestroyController;
use App\Http\Controllers\AdminPanel\Product\EditController as ProductEditController;
use App\Http\Controllers\AdminPanel\Product\IndexController as ProductIndexController;
use App\Http\Controllers\AdminPanel\Product\ShowController as ProductShowController;
use App\Http\Controllers\AdminPanel\Product\StoreController as ProductStoreController;
use App\Http\Controllers\AdminPanel\Product\UpdateController as ProductUpdateController;
use App\Http\Controllers\AdminPanel\Tag\DestroyController as TagDestroyController;
use App\Http\Controllers\AdminPanel\Tag\IndexController as TagIndexController;
use App\Http\Controllers\AdminPanel\Tag\ShowController as TagShowController;
use App\Http\Controllers\AdminPanel\Tag\StoreController as TagStoreController;
use App\Http\Controllers\AdminPanel\Tag\UpdateController as TagUpdateController;
use App\Http\Controllers\AdminPanel\User\CreateController as UserCreateController;
use App\Http\Controllers\AdminPanel\User\DestroyController as UserDestroyController;
use App\Http\Controllers\AdminPanel\User\IndexController as UserIndexController;
use App\Http\Controllers\AdminPanel\User\ShowController as UserShowController;
use App\Http\Controllers\AdminPanel\User\StoreController as UserStoreController;
use App\Http\Controllers\AdminPanel\User\UpdateController as UserUpdateController;
use App\Http\Controllers\GdePosController;
use Illuminate\Support\Facades\Route;

require __DIR__ . '/auth.php';

// Страница логина
Route::get('/login', LoginPageController::class)
    ->name('page.login');

Route::get('/frontend', static fn() => redirect()->away(config('app.frontend_url')))
     ->name('frontend');

// Административные маршруты
Route::middleware(['auth'])
    ->prefix('admin')
    ->group(function () {
        // 1) Просмотр маршрутов: админ + модератор
        Route::middleware(['moderator.readonly'])
            ->group(function () {
                Route::get('/test-tracking', GdePosController::class);

                Route::get('main', IndexController::class)
                    ->name('main.index');

                // Категории
                Route::get('categories', CategoryIndexController::class)
                    ->name('category.index');
                Route::get('categories/{category}', CategoryShowController::class)
                    ->name('category.show');

                // Товары
                Route::get('products', ProductIndexController::class)
                    ->name('product.index');
                Route::get('products/create', ProductCreateController::class)
                    ->name('product.create');
                Route::get('products/{product}', ProductShowController::class)
                    ->name('product.show');
                Route::get('products/{product}/edit', ProductEditController::class)
                    ->name('product.edit');

                // Теги
                Route::get('tags', TagIndexController::class)
                    ->name('tag.index');
                Route::get('tags/{tag}', TagShowController::class)
                    ->name('tag.show');

                // Цвета
                Route::get('colors', ColorIndexController::class)
                    ->name('color.index');
                Route::get('colors/{color}', ColorShowController::class)
                    ->name('color.show');

                // Пользователи
                Route::get('users', UserIndexController::class)
                    ->name('user.index');
                Route::get('users/create', UserCreateController::class)
                    ->name('user.create');
                Route::get('users/{user}', UserShowController::class)
                    ->name('user.show');

                // Заказы
                Route::get('orders', OrderIndexController::class)
                    ->name('order.index');
                Route::get('orders/{order}', OrderShowController::class)
                    ->name('order.show');
                Route::get('orders/{order}/edit', OrderEditController::class)
                    ->name('order.edit');

                // Доставка (GET)
                Route::get('delivery', DeliveryIndexController::class)
                    ->name('delivery.index');
                Route::get('delivery/{delivery}', DeliveryShowController::class)
                    ->name('delivery.show');

                // Gdeposylka API (если нужно)
                // Route::get('gdeposylka/couriers', [GdeposylkaController::class, 'index']);
                // Route::get('gdeposylka/detect/{trackingNumber}', [GdeposylkaController::class, 'detect']);
                // Route::get('gdeposylka/track/{trackingNumber}', [GdeposylkaController::class, 'track']);
                // Route::get('gdeposylka/fetch/{trackingNumber}', [GdeposylkaController::class, 'fetch']);
            });

        // 2) Мутации: только админ
        Route::middleware(['admin'])
            ->group(function () {
                // Категории
                Route::post('categories', CategoryStoreController::class)
                    ->name('category.store');
                Route::patch('categories/{category}', CategoryUpdateController::class)
                    ->name('category.update');
                Route::delete('categories/{category}', CategoryDestroyController::class)
                    ->name('category.destroy');

                // Товары
                Route::post('products', ProductStoreController::class)
                    ->name('product.store');
                Route::patch('products/{product}', ProductUpdateController::class)
                    ->name('product.update');
                Route::delete('products/{product}', ProductDestroyController::class)
                    ->name('product.destroy');

                // Теги
                Route::post('tags', TagStoreController::class)
                    ->name('tag.store');
                Route::patch('tags/{tag}', TagUpdateController::class)
                    ->name('tag.update');
                Route::delete('tags/{tag}', TagDestroyController::class)
                    ->name('tag.destroy');

                // Цвета
                Route::post('colors', ColorStoreController::class)
                    ->name('color.store');
                Route::patch('colors/{color}', ColorUpdateController::class)
                    ->name('color.update');
                Route::delete('colors/{color}', ColorDestroyController::class)
                    ->name('color.destroy');

                // Пользователи
                Route::post('users', UserStoreController::class)
                    ->name('user.store');
                Route::patch('users/{user}', UserUpdateController::class)
                    ->name('user.update');
                Route::delete('users/{user}', UserDestroyController::class)
                    ->name('user.destroy');

                // Заказы
                Route::patch('orders/{order}', OrderUpdateController::class)
                    ->name('order.update');
                Route::delete('orders/{order}', OrderDestroyController::class)
                    ->name('order.destroy');
                Route::patch('orders/{order}/positions', PositionUpdateController::class)
                    ->name('order.position.update');
                Route::post('orders/{order}/delivery-status', DeliveryStatusStoreController::class)
                    ->name('order.delivery-status.store');

                // Доставка
                Route::post('delivery', DeliveryStoreController::class)
                    ->name('delivery.store');
                Route::patch('delivery/{delivery}', DeliveryUpdateController::class)
                    ->name('delivery.update');
                Route::delete('delivery/{delivery}', DeliveryDestroyController::class)
                    ->name('delivery.destroy');
            });
    });

Route::fallback(static fn() => redirect()->route('main.index'));
