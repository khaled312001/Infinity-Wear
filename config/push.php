<?php

return [
    /*
    |--------------------------------------------------------------------------
    | VAPID Keys for Web Push Notifications
    |--------------------------------------------------------------------------
    |
    | These keys are used for Web Push notifications. You can generate them
    | using the web-push library or online tools.
    |
    */

    'vapid' => [
        'subject' => env('PUSH_VAPID_SUBJECT', config('app.url')),
        'public_key' => env('PUSH_VAPID_PUBLIC_KEY', ''),
        'private_key' => env('PUSH_VAPID_PRIVATE_KEY', ''),
    ],

    /*
    |--------------------------------------------------------------------------
    | Push Notification Settings
    |--------------------------------------------------------------------------
    |
    | Configuration for push notifications behavior
    |
    */

    'settings' => [
        'enabled' => env('PUSH_NOTIFICATIONS_ENABLED', true),
        'default_icon' => env('PUSH_DEFAULT_ICON', '/images/logo.png'),
        'default_badge' => env('PUSH_DEFAULT_BADGE', '/images/logo.png'),
        'default_url' => env('PUSH_DEFAULT_URL', '/admin/notifications'),
        'ttl' => env('PUSH_TTL', 86400), // 24 hours
        'urgency' => env('PUSH_URGENCY', 'normal'), // low, normal, high
    ],

    /*
    |--------------------------------------------------------------------------
    | Notification Types
    |--------------------------------------------------------------------------
    |
    | Configuration for different notification types
    |
    */

    'types' => [
        'order' => [
            'title' => 'طلب جديد',
            'icon' => '/images/order-icon.png',
            'url' => '/admin/orders',
            'enabled' => true,
        ],
        'contact' => [
            'title' => 'رسالة اتصال جديدة',
            'icon' => '/images/contact-icon.png',
            'url' => '/admin/contacts',
            'enabled' => true,
        ],
        'whatsapp' => [
            'title' => 'رسالة واتساب جديدة',
            'icon' => '/images/whatsapp-icon.png',
            'url' => '/admin/whatsapp',
            'enabled' => true,
        ],
        'system' => [
            'title' => 'إشعار النظام',
            'icon' => '/images/system-icon.png',
            'url' => '/admin/notifications',
            'enabled' => true,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Types
    |--------------------------------------------------------------------------
    |
    | Configuration for different user types that can receive notifications
    |
    */

    'user_types' => [
        'admin' => [
            'enabled' => true,
            'default_notifications' => ['order', 'contact', 'whatsapp', 'system'],
        ],
        'customer' => [
            'enabled' => false,
            'default_notifications' => ['order'],
        ],
        'importer' => [
            'enabled' => false,
            'default_notifications' => ['order'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Cleanup Settings
    |--------------------------------------------------------------------------
    |
    | Settings for cleaning up old subscriptions
    |
    */

    'cleanup' => [
        'enabled' => true,
        'days_old' => 30, // Delete subscriptions older than 30 days
        'schedule' => 'daily', // How often to run cleanup
    ],
];
