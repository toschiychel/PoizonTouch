<?php

namespace App\Services\AdminPanel\Currency;

use App\Models\Currency;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;
use Exception;

class CurrencyRateService
{
    public function getActualRate(bool $forceApi = false)
    {
        // 1. Проверить, есть ли свежий курс в таблице currencies (< 8 часов)
        $now = Carbon::now();
        $currency = Currency::where('code', 'CNY')->first();

        if (!$forceApi && $currency && $currency->fetched_at->gt($now->subHours(8))) {
            return (float) $currency->rate_to_rub;
        }

        // 2. Если нет — обратиться к API
        try {
            $response = Http::timeout(5)
                ->get('https://api.exchangerate.host/convert', [
                    'access_key' => '1635365da426ef5d50296308e6fcaf3c',
                    'from'       => 'CNY',
                    'to'         => 'RUB',
                    'amount'     => 1,
                ]);
        } catch (Exception $e) {
            Log::error("Currency API request failed: {$e->getMessage()}");
            throw new Exception('Не удалось получить курс валюты: ошибка соединения');
        }

        if (!$response->ok() || !$response->json('success')) {
            $errorInfo = $response->json('error.info') ?? 'неизвестная ошибка';
            Log::warning("Currency API returned error: {$errorInfo}");
            throw new Exception("Не удалось получить курс валюты: {$errorInfo}");
        }

        $rate = $response->json('info.quote');

        // 3. Кешировать и сохранить в таблицу
        $now = Carbon::now();

        if ($currency) {
            $currency->rate_to_rub = $rate;
            $currency->fetched_at = $now;
            $currency->save();
        } else {
            Currency::create([
                'code' => 'CNY',
                'rate_to_rub' => $rate,
                'fetched_at' => $now,
            ]);
        }
        
        return (float) $rate;
    }
}
