<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Cloudinary Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your Cloudinary settings. Cloudinary is a cloud
    | service that provides image and video management solutions.
    |
    */

    'cloud_name' => env('CLOUDINARY_CLOUD_NAME', 'dummy'),
    'api_key' => env('CLOUDINARY_API_KEY', '787844769525158'),
    'api_secret' => env('CLOUDINARY_API_SECRET', 'uZa3Vo50vIgiE4UizMtVMW_OAHI'),
    'secure' => env('CLOUDINARY_SECURE', true),

    /*
    |--------------------------------------------------------------------------
    | Default Upload Settings
    |--------------------------------------------------------------------------
    |
    | Default settings for file uploads to Cloudinary
    |
    */

    'default_folder' => env('CLOUDINARY_DEFAULT_FOLDER', 'infinitywearsa'),
    'default_quality' => env('CLOUDINARY_DEFAULT_QUALITY', 'auto'),
    'default_format' => env('CLOUDINARY_DEFAULT_FORMAT', 'auto'),

    /*
    |--------------------------------------------------------------------------
    | Image Transformations
    |--------------------------------------------------------------------------
    |
    | Default image transformation settings
    |
    */

    'thumbnail' => [
        'width' => 300,
        'height' => 300,
        'crop' => 'fill',
        'gravity' => 'auto',
        'quality' => 'auto',
    ],

    'preview' => [
        'width' => 600,
        'height' => 600,
        'crop' => 'limit',
        'quality' => 'auto',
    ],

    'full_size' => [
        'quality' => 'auto',
        'fetch_format' => 'auto',
    ],
];
