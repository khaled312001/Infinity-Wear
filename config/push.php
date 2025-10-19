<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Push Notifications Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains the configuration for push notifications using
    | Web Push protocol. Configure your VAPID keys and notification settings.
    |
    */

    'settings' => [
        'enabled' => env('PUSH_NOTIFICATIONS_ENABLED', true),
        'default_icon' => '/images/notification-icon.png',
        'default_badge' => '/images/badge-icon.png',
        'default_url' => '/dashboard',
        'ttl' => 86400, // 24 hours
    ],

    'vapid' => [
        'subject' => env('PUSH_VAPID_SUBJECT', 'mailto:admin@infinitywear.com'),
        'public_key' => env('PUSH_VAPID_PUBLIC_KEY'),
        'private_key' => env('PUSH_VAPID_PRIVATE_KEY'),
    ],

    'types' => [
        'order' => [
            'title' => 'طلب جديد',
            'icon' => '/images/order-icon.png',
            'url' => '/admin/orders',
            'sound' => 'order-notification.mp3',
        ],
        'contact' => [
            'title' => 'رسالة اتصال جديدة',
            'icon' => '/images/contact-icon.png',
            'url' => '/admin/contacts',
            'sound' => 'contact-notification.mp3',
        ],
        'whatsapp' => [
            'title' => 'رسالة واتساب جديدة',
            'icon' => '/images/whatsapp-icon.png',
            'url' => '/admin/whatsapp',
            'sound' => 'whatsapp-notification.mp3',
        ],
        'importer_order' => [
            'title' => 'طلب مستورد جديد',
            'icon' => '/images/importer-icon.png',
            'url' => '/admin/importer-orders',
            'sound' => 'importer-notification.mp3',
        ],
        'system' => [
            'title' => 'إشعار النظام',
            'icon' => '/images/system-icon.png',
            'url' => '/admin/notifications',
            'sound' => 'system-notification.mp3',
        ],
        'task' => [
            'title' => 'مهمة جديدة',
            'icon' => '/images/task-icon.png',
            'url' => '/admin/tasks',
            'sound' => 'task-notification.mp3',
        ],
        'marketing' => [
            'title' => 'تقرير تسويقي',
            'icon' => '/images/marketing-icon.png',
            'url' => '/admin/marketing',
            'sound' => 'marketing-notification.mp3',
        ],
        'sales' => [
            'title' => 'تقرير مبيعات',
            'icon' => '/images/sales-icon.png',
            'url' => '/admin/sales',
            'sound' => 'sales-notification.mp3',
        ],
    ],

    'channels' => [
        'admin' => [
            'enabled' => true,
            'types' => ['order', 'contact', 'whatsapp', 'importer_order', 'system', 'task', 'marketing', 'sales'],
        ],
        'sales' => [
            'enabled' => true,
            'types' => ['order', 'contact', 'task', 'sales'],
        ],
        'marketing' => [
            'enabled' => true,
            'types' => ['contact', 'whatsapp', 'task', 'marketing'],
        ],
        'importer' => [
            'enabled' => true,
            'types' => ['importer_order', 'system'],
        ],
    ],

    'rate_limiting' => [
        'enabled' => true,
        'max_per_minute' => 10,
        'max_per_hour' => 100,
        'max_per_day' => 1000,
    ],

    'cleanup' => [
        'enabled' => true,
        'old_subscriptions_days' => 30,
        'failed_notifications_days' => 7,
    ],
];