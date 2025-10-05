<?php

return [
    /*
    |--------------------------------------------------------------------------
    | WhatsApp Configuration
    |--------------------------------------------------------------------------
    |
    | إعدادات الواتساب الأساسية للنظام
    |
    */

    'primary_number' => env('WHATSAPP_PRIMARY_NUMBER', '966599476482'),
    
    'api' => [
        'enabled' => env('WHATSAPP_API_ENABLED', true),
        'provider' => env('WHATSAPP_API_PROVIDER', 'auto_api'), // auto_api, free_api, aisensy, whapi, or whatsapp_web
        'api_token' => env('WHATSAPP_API_TOKEN'),
        'webhook_url' => env('WHATSAPP_WEBHOOK_URL'),
        'access_token' => env('WHATSAPP_ACCESS_TOKEN'),
        'phone_number_id' => env('WHATSAPP_PHONE_NUMBER_ID'),
        'business_account_id' => env('WHATSAPP_BUSINESS_ACCOUNT_ID'),
        
        // Free API Configuration
        'free_api' => [
            'base_url' => env('WHATSAPP_FREE_API_URL', 'https://api.whatsapp.com'),
            'session_id' => env('WHATSAPP_SESSION_ID', 'infinity_wear_session'),
            'webhook_token' => env('WHATSAPP_WEBHOOK_TOKEN', 'infinity_webhook_token'),
        ],
        
        // Auto API Configuration (إرسال تلقائي)
        'auto_api' => [
            'url' => env('WHATSAPP_AUTO_API_URL', 'https://api.whatsapp.com'),
            'key' => env('WHATSAPP_AUTO_API_KEY'),
            'session_id' => env('WHATSAPP_AUTO_SESSION_ID', 'infinity_wear_auto'),
            'baileys_url' => env('WHATSAPP_BAILEYS_URL', 'http://localhost:3000'),
            'business_url' => env('WHATSAPP_BUSINESS_URL', 'https://graph.facebook.com/v18.0'),
            'alternative_url' => env('WHATSAPP_ALTERNATIVE_URL', 'https://api.whatsapp.com/send'),
        ],
    ],

    'web' => [
        'enabled' => env('WHATSAPP_WEB_ENABLED', true),
        'session_path' => storage_path('app/whatsapp-session'),
    ],

    'features' => [
        'auto_reply' => env('WHATSAPP_AUTO_REPLY', false),
        'message_templates' => env('WHATSAPP_MESSAGE_TEMPLATES', false),
        'media_support' => env('WHATSAPP_MEDIA_SUPPORT', true),
    ],

    'limits' => [
        'max_message_length' => 4096,
        'max_media_size' => 16 * 1024 * 1024, // 16MB
        'rate_limit_per_hour' => 1000,
    ],
];