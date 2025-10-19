<?php

/**
 * إعدادات البريد الإلكتروني الرسمي - Infinity Wear
 * info@infinitywearsa.com
 */

return [
    'mail' => [
        'default' => 'smtp',
        'mailers' => [
            'smtp' => [
                'transport' => 'smtp',
                'host' => 'smtp.hostinger.com',
                'port' => 465,
                'encryption' => 'ssl',
                'username' => 'info@infinitywearsa.com',
                'password' => 'Info2025#*',
                'timeout' => null,
                'auth_mode' => null,
            ],
        ],
        'from' => [
            'address' => 'info@infinitywearsa.com',
            'name' => 'Infinity Wear',
        ],
    ],
    
    'imap' => [
        'host' => 'imap.hostinger.com',
        'port' => 993,
        'encryption' => 'ssl',
        'username' => 'info@infinitywearsa.com',
        'password' => 'Info2025#*',
    ],
    
    'pop' => [
        'host' => 'pop.hostinger.com',
        'port' => 995,
        'encryption' => 'ssl',
        'username' => 'info@infinitywearsa.com',
        'password' => 'Info2025#*',
    ],
];
