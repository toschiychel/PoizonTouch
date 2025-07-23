<?php

use App\Http\Controllers\Api\YooKassa\CreatePaymentController;
use App\Http\Controllers\Api\Account\OrderListController;
use App\Http\Controllers\Api\Address\AddressSuggestController;
use App\Http\Controllers\Api\Main\IndexController;
use App\Http\Controllers\Api\Order\StoreController;
use App\Http\Controllers\Api\Product\FilterListController;
use App\Http\Controllers\Api\Product\IndexController as ProductIndexController;
use App\Http\Controllers\Api\Product\ShowController;
use App\Http\Controllers\Api\Telegram\DeepLinkController;
use App\Http\Controllers\Api\Telegram\QRCode\QrCodeController;
use App\Http\Controllers\Api\User\UpdateController;
use App\Http\Controllers\Api\YooKassa\YooKassaWebhookController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware(['api-breeze', 'api'])->group(function () {
    // Регистрация
    Route::post('/register', [RegisteredUserController::class, 'store']);
    
    // Логин
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
    
    // Получение текущего пользователя
    Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
        return $request->user();
    });
    
    // Изменение данных
    Route::patch('/user/{user}', UpdateController::class);
    
    // Логаут
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->middleware('auth:sanctum');    

    Route::middleware('auth:sanctum')->get('/telegram/qr', function(Request $request) {
        return $request->user();
    });
    
    Route::middleware('auth:sanctum')->get('/telegram/qr', QrCodeController::class);
});


Route::get('/main', IndexController::class);
Route::post('/products', ProductIndexController::class);
Route::get('/products/filters', FilterListController::class);
Route::get('/products/{product}', ShowController::class);

Route::get('/account/{user}/orders', OrderListController::class);

Route::post('/orders/{user}/create', StoreController::class);
Route::post('/order/{order}/createPayment', [CreatePaymentController::class, 'createPayment']);
Route::post('v1/webhook/yookassa', [YooKassaWebhookController::class, 'handle']);

Route::post('/dadata/address-suggest', [AddressSuggestController::class, 'suggest']);





