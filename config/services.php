<?php

return [
    'helpdesk' => [
        'base_uri' => env('HELPDESK_SERVICE_URI'),
        'secret' => env('HELPDESK_SERVICE_SECRET')
    ],

    'procurement' => [
        'base_uri' => env('PROCUREMENT_SERVICE_URI'),
        'secret' => env('PROCUREMENT_SERVICE_SECRET')
    ],

    'stock' => [
        'base_uri' => env('STOCK_SERVICE_URI'),
        'secret' => env('STOCK_SERVICE_SECRET')
    ],

    'notification' => [
        'base_uri' => env('NOTIFICATION_SERVICE_URI'),
        'secret' => env('NOTIFICATION_SERVICE_SECRET')
    ],
];
