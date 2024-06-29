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
            'throw' => true ,
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
            'throw' => true ,
        ],
        'document' => [
            'driver' => 'local',
            'root' => storage_path('data/documents') ,
            'url' => env('APP_URL').'/storage/documents',
            'throw' => true ,
        ],
        'legaldraft' => [
            'driver' => 'local',
            'root' => storage_path('data/legaldrafts') ,
            'url' => env('APP_URL').'/storage/legaldrafts',
            'throw' => true ,
        ],
        'regulator' => [
            'driver' => 'local',
            'root' => storage_path('data/regulators') ,
            'url' => env('APP_URL').'/storage/regulators',
            'throw' => true ,
        ],

        'meeting' => [
            'driver' => 'local',
            'root' => storage_path('data/meetings') ,
            'url' => env('APP_URL').'/storage/meetings',
            'throw' => true ,
        ],

        'comment' => [
            'driver' => 'local',
            'root' => storage_path('data/comments') ,
            'url' => env('APP_URL').'/storage/comments',
            'throw' => true ,
        ],
        
        'attendant' => [
            'driver' => 'local',
            'root' => storage_path('data/attendants') ,
            'url' => env('APP_URL').'/storage/attendants',
            'throw' => true ,
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
            'throw' => true ,
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
    ],

];
