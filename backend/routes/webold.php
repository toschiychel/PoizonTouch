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
use App\Http\Controllers\AdminPanel\Delivery\StoreController;
use App\Http\Controllers\AdminPanel\Delivery\UpdateController as DeliveryUpdateController;
use App\Http\Controllers\AdminPanel\Gdeposylka\GdeposylkaController;
use App\Http\Controllers\AdminPanel\Main\IndexController;
use App\Http\Controllers\AdminPanel\Order\DeliveryStatus\StoreController as DeliveryStatusStoreController;
use App\Http\Controllers\AdminPanel\Order\DestroyController;
use App\Http\Controllers\AdminPanel\Order\EditController;
use App\Http\Controllers\AdminPanel\Order\IndexController as OrderIndexController;
use App\Http\Controllers\AdminPanel\Order\Position\UpdateController as PositionUpdateController;
use App\Http\Controllers\AdminPanel\Order\ShowController;
use App\Http\Controllers\AdminPanel\Order\UpdateController;
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
use App\Services\AdminPanel\Order\DeliveryStatus\GdePosylka\GdeposylkaService;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

require __DIR__ . '/auth.php';

Route::get('/login', LoginPageController::class)->name('page.login');



Route::group(['middleware' => ['auth', 'admin'], 'prefix' => 'admin'], function () {

    // Route::group(['prefix' => 'gdeposylka'], function () {
    //     Route::get('couriers', [GdeposylkaController::class, 'index']);
    //     Route::get('detect/{trackingNumber}', [GdeposylkaController::class, 'detect']);
    //     Route::get('track/{trackingNumber}', [GdeposylkaController::class, 'track']);
    //     Route::get('fetch/{trackingNumber}', [GdeposylkaController::class, 'fetch']);
    // });

    Route::get('/test-tracking', GdePosController::class);

    Route::group(['prefix' => 'main'], function () {
        Route::get('/', IndexController::class)->name('main.index');
    });

    Route::group(['prefix' => 'categories'], function () {
        Route::get('/', CategoryIndexController::class)->name('category.index');
        Route::post('/', CategoryStoreController::class)->name('category.store');
        Route::get('/{category}', CategoryShowController::class)->name('category.show');
        Route::patch('/{category}', CategoryUpdateController::class)->name('category.update');
        Route::delete('/{category}', CategoryDestroyController::class)->name('category.destroy');
    });

    Route::group(['prefix' => 'products'], function () {
        Route::get('/', ProductIndexController::class)->name('product.index');
        Route::get('/create', ProductCreateController::class)->name('product.create');
        Route::post('/', ProductStoreController::class)->name('product.store');
        Route::get('/{product}', ProductShowController::class)->name('product.show');
        Route::get('{product}/edit', ProductEditController::class)->name('product.edit');
        Route::patch('/{product}', ProductUpdateController::class)->name('product.update');
        Route::delete('/{product}', ProductDestroyController::class)->name('product.destroy');
    });

    Route::group(['prefix' => 'tags'], function () {
        Route::get('/', TagIndexController::class)->name('tag.index');
        Route::post('/', TagStoreController::class)->name('tag.store');
        Route::get('/{tag}', TagShowController::class)->name('tag.show');
        Route::patch('/{tag}', TagUpdateController::class)->name('tag.update');
        Route::delete('/{tag}', TagDestroyController::class)->name('tag.destroy');
    });

    Route::group(['prefix' => 'colors'], function () {
        Route::get('/', ColorIndexController::class)->name('color.index');
        Route::post('/', ColorStoreController::class)->name('color.store');
        Route::get('/{color}', ColorShowController::class)->name('color.show');
        Route::patch('/{color}', ColorUpdateController::class)->name('color.update');
        Route::delete('/{color}', ColorDestroyController::class)->name('color.destroy');
    });

    Route::group(['prefix' => 'users'], function () {
        Route::get('/', UserIndexController::class)->name('user.index');
        Route::get('/create', UserCreateController::class)->name('user.create');
        Route::post('/', UserStoreController::class)->name('user.store');
        Route::get('/{user}', UserShowController::class)->name('user.show');
        Route::patch('/{user}', UserUpdateController::class)->name('user.update');
        Route::delete('/{user}', UserDestroyController::class)->name('user.destroy');
    });

    Route::group(['prefix' => 'orders'], function () {
        Route::get('/', OrderIndexController::class)->name('order.index');
        Route::get('/{order}', ShowController::class)->name('order.show');
        Route::get('/order/{order}/edit', EditController::class)->name('order.edit');
        Route::patch('/{order}', UpdateController::class)->name('order.update');
        Route::delete('/{order}', DestroyController::class)->name('order.destroy');

        Route::patch('/{order}/positions', PositionUpdateController::class)->name('order.position.update');
        
        Route::post('/{order}/delivery-status', DeliveryStatusStoreController::class)->name('order.delivery-status.store');
    });

    Route::group(['prefix' => 'delivery'], function () {
        Route::get('/', DeliveryIndexController::class)->name('delivery.index');
        Route::post('/', StoreController::class)->name('delivery.store');
        Route::get('/{delivery}', DeliveryShowController::class)->name('delivery.show');
        Route::patch('/{delivery}', DeliveryUpdateController::class)->name('delivery.update');
        Route::delete('/{delivery}', DeliveryDestroyController::class)->name('delivery.destroy');
    });
});

Route::fallback(function () {
    return redirect()->route('main.index');
});

