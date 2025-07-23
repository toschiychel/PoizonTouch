<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'gdeposylka' => [
        'token' => env('GDEPOSYLKA_TOKEN'),
        'mock'  => env('GDEPOSYLKA_MOCK', false),
    ],

    'post' => [
        'russia' => [
            'wsdl' => env('POST_RUSSIA_BASE_URI', 'https://tracking.russianpost.ru/rtm34?wsdl'),
            'login'  => env('POST_RUSSIA_LOGIN'),
            'password' => env('POST_RUSSIA_PASSWORD'),
        ],
    ],

    'yookassa' => [
        'shop_id'    => env('YOOKASSA_SHOP_ID'),
        'secret_key' => env('YOOKASSA_SECRET_KEY'),
    ],

    'telegram' => [
        'bot_token' => env('TELEGRAM_BOT_TOKEN'),
        'admin_telegram_chat_id' => env('ADMIN_TELEGRAM_CHAT_ID'),
        'username' => env('TELEGRAM_BOT_USERNAME'),
    ],

];
