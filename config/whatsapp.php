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
        'enabled' => env('WHATSAPP_API_ENABLED', false),
        'provider' => env('WHATSAPP_API_PROVIDER', 'aisensy'), // aisensy or whapi
        'api_token' => env('WHATSAPP_API_TOKEN'),
        'webhook_url' => env('WHATSAPP_WEBHOOK_URL'),
        'access_token' => env('WHATSAPP_ACCESS_TOKEN'),
        'phone_number_id' => env('WHATSAPP_PHONE_NUMBER_ID'),
        'business_account_id' => env('WHATSAPP_BUSINESS_ACCOUNT_ID'),
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