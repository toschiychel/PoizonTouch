<?php

namespace App\Services\AdminPanel\Order\DeliveryStatus\GdePosylka;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GdeposylkaService implements GdeposylkaContract
{
    protected string $base = 'https://gdeposylka.ru/api/v4';
    protected string $token;

    public function __construct()
    {
        $this->token = config('services.gdeposylka.token');
    }

    protected function request(string $url, array $params = [])
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'X-Authorization-Token' => $this->token,
        ])->get($this->base . $url, $params);

        if (!$response->ok() || $response->json('result') === 'error') {
            Log::error('Gdeposylka API error', ['url' => $url, 'body' => $response->body()]);
            throw new Exception('Gdeposylka API error: ' . $response->json('error', 'Unknown error'));
        }

        return $response->json();
    }

    /**
     * Получить список всех доступных служб доставки
     *
     * @return array
     */
    public function listCouriers()
    {
        $data = $this->request('/couriers');
        return $data['data'] ?? [];
    }

    /**
     * Определить службу по номеру трека
     *
     * @param string $trackingNumber
     * @return array
     */
    public function detectCourier(string $trackingNumber)
    {
        $path = "/tracker/detect/{$trackingNumber}";
        $data = $this->request($path);
 
        return $data['data'] ?? [];
    }

    /**
     * Получить полный трекинг по номеру (самостоятельно определяет courier slug)
     *
     * @param string $trackingNumber
     * @return array
     * @throws Exception
     */
    public function getTracking(string $trackingNumber)
    {
        $detected = $this->detectCourier($trackingNumber);
        if (empty($detected) || !isset($detected[0]['courier']['slug'])) {
            throw new Exception("Courier not detected for tracking number {$trackingNumber}");
        }

        $slug = $detected[0]['courier']['slug'];
        $path = "/tracker/{$slug}/{$trackingNumber}";
        $data = $this->request($path);

        return $data['data'] ?? [];
    }

    /**
     * Проверить статус трека и вернуть полный трекинг, либо выбросить исключение при ожидании
     *
     * @param string $trackingNumber
     * @return array
     * @throws Exception
     */
    public function fetchTracking(string $trackingNumber)
    {
        $result = $this->getTracking($trackingNumber);

        if (isset($result['is_active'], $result['checkpoints']) && $result['is_active'] && empty($result['checkpoints'])) {
            throw new Exception('Tracking is in waiting state, try again later');
        }

        return $result;
    }
}
