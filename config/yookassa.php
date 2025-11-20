<?php

return [
    /*
    |--------------------------------------------------------------------------
    | YooKassa Settings
    |--------------------------------------------------------------------------
    |
    | These settings are used to integrate with YooKassa payment system.
    |
    */
    
    'shop_id' => env('YOOKASSA_SHOP_ID'),
    
    'secret_key' => env('YOOKASSA_SECRET_KEY'),
    
    'api_url' => env('YOOKASSA_API_URL', 'https://api.yookassa.ru/v3'),
];