<?php

return [

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    // =========================
    // 🟢 ADD THIS MIDTRANS PART
    // =========================
    'midtrans' => [
        'merchant_id'   => env('MIDTRANS_MERCHANT_ID'),
        'client_key'    => env('MIDTRANS_CLIENT_KEY'),
        'server_key'    => env('MIDTRANS_SERVER_KEY'),
        'is_production' => env('MIDTRANS_IS_PRODUCTION', false),
        'is_sanitized'  => env('MIDTRANS_IS_SANITIZED', true),
        'is_3ds'        => env('MIDTRANS_IS_3DS', true),
    ],

];
