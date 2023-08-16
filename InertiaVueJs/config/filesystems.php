<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => env('FILESYSTEM_DISK', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been set up for each driver as an example of the required values.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
            'throw' => false,
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
            'throw' => false,
        ],

        'corporate_clients_register_files' => [
            'driver' => 'local',
            'root' => storage_path('app/corporate_clients_register_files'),
            'url' => env('APP_URL').'/storage/corporate_clients_register_files',
            'visibility' => 'public',
            'throw' => false,
        ],

        'corporate_clients_exoneration_titles' => [
            'driver' => 'local',
            'root' => storage_path('app/corporate_clients_exoneration_titles'),
            'url' => env('APP_URL').'/storage/corporate_clients_exoneration_titles',
            'visibility' => 'public',
            'throw' => false,
        ],

        'app_logos' => [
            'driver' => 'local',
            'root' => storage_path('app/app_logos'),
            'url' => env('APP_URL').'/storage/app_logos',
            'visibility' => 'public',
            'throw' => false,
        ],

        'bg_images' => [
            'driver' => 'local',
            'root' => storage_path('app/bg_images'),
            'url' => env('APP_URL').'/storage/bg_images',
            'visibility' => 'public',
            'throw' => false,
        ],

        'publication_files' => [
            'driver' => 'local',
            'root' => storage_path('app/publication_files'),
            'url' => env('APP_URL').'/storage/publication_files',
            'visibility' => 'public',
            'throw' => false,
        ],

        'alert_files' => [
            'driver' => 'local',
            'root' => storage_path('app/alert_files'),
            'url' => env('APP_URL').'/storage/alert_files',
            'visibility' => 'public',
            'throw' => false,
        ],
        'companies_logos' => [
            'driver' => 'local',
            'root' => storage_path('app/companies_logos'),
            'url' => env('APP_URL').'/storage/companies_logos',
            'visibility' => 'public',
            'throw' => false,
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
            'throw' => false,
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
        public_path('storage/corporate_clients_register_files') => storage_path('app/corporate_clients_register_files'),
        public_path('storage/corporate_clients_exoneration_titles') => storage_path('app/corporate_clients_exoneration_titles'),
        public_path('storage/app_logos') => storage_path('app/app_logos'),
        public_path('storage/bg_images') => storage_path('app/bg_images'),
        public_path('storage/publication_files') => storage_path('app/publication_files'),
        public_path('storage/alert_files') => storage_path('app/alert_files'),
        public_path('storage/companies_logos') => storage_path('app/companies_logos'),
    ],
];
