<?php

namespace App\Services\AdminPanel\Order\DeliveryStatus\GdePosylka\RussianPost;

use App\Exceptions\TrackingNotSupportedException;
use App\Services\AdminPanel\Order\DeliveryStatus\TrackingServiceInterface;
use Illuminate\Support\Facades\Http;

class RussianPostService implements TrackingServiceInterface
{
    protected \SoapClient $client;

    public function __construct()
    {
        $wsdl    = storage_path('wsdl/rtm34.wsdl'); // локальный WSDL
        $login   = config('services.post.russia.login');
        $pass    = config('services.post.russia.password');

        // создаём stream_context, разрешающий follow_location и проверку SSL
        $ctx = stream_context_create([
            'http' => [
                'follow_location' => 1,
                'max_redirects'   => 5,
            ],
            'ssl' => [
                'verify_peer'      => true,
                'verify_peer_name' => true,
                'cafile'           => '/etc/ssl/certs/ca-certificates.crt',
            ],
        ]);

        $options = [
            'trace'          => true,
            'soap_version'   => \SOAP_1_2,
            'cache_wsdl'     => \WSDL_CACHE_NONE,
            'login'          => $login,
            'password'       => $pass,
            'features'       => \SOAP_SINGLE_ELEMENT_ARRAYS,
            'stream_context' => $ctx,    // ← вот он
        ];

        $this->client = new \SoapClient($wsdl, $options);
    }


    /**
     * Запрашивает историю операций getOperationHistory и переводит её в единый формат
     *
     * @param string $trackingNumber
     * @return array{courier: array{name:string}, checkpoints: array}
     * @throws TrackingNotSupportedException
     */
    public function track(string $trackingNumber): array
    {
        // 1) Формируем тело запроса
        $params = [
            'OperationHistoryRequest' => [
                'Barcode'     => $trackingNumber,
                'MessageType' => 0,       // 0 = операции по отправлению
                'Language'    => 'RUS',   // 'ENG' – английский
            ],
            'AuthorizationHeader' => [
                'login'    => config('services.post.russia.login'),
                'password' => config('services.post.russia.password'),
            ],
        ];

        // 2) Делаем SOAP-запрос
        try {
            $response = $this->client->getOperationHistory($params);
        } catch (\SoapFault $e) {
            // авторизация не прошла или отправление не найдено
            throw new TrackingNotSupportedException($e->getMessage());
        }

        // 3) Извлекаем записи
        $raw = $response->OperationHistoryData->historyRecord ?? [];
        $records = is_array($raw) ? $raw : [$raw];

        if (empty($records)) {
            throw new TrackingNotSupportedException();
        }

        // 4) Мапим в единую структуру
        $checkpoints = array_map(function ($rec) {
            $code = RussianPostStatusMapper::toKey((string) $rec->OperationParameters->OperAttr->Id);
            return [
                'status_code' => $code,
                'status_name' => (string) $rec->OperationParameters->OperAttr->Name,
                'time' => (string) $rec->OperationParameters->OperDate,
                'location_translated' => (string) $rec->AddressParameters->OperationAddress->Description,
            ];
        }, $records);
        $checkpoints = array_reverse($checkpoints);
        return [
            'courier' => ['name' => 'Почта России'],
            'checkpoints' => $checkpoints,
        ];
    }
}
