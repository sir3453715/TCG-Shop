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

    'default' => env('FILESYSTEM_DRIVER', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
        ],

        'portfolios' => [
            'driver' => 'local',
            'root' => storage_path('app/public/uploads/portfolios'),
            'url' => env('APP_URL').'/storage/uploads/portfolios',
            'visibility' => 'public',
        ],

        'google' => [
            'driver' => 'google',
            'clientId' => env('GOOGLE_DRIVE_CLIENT_ID'),
            'clientSecret' => env('GOOGLE_DRIVE_CLIENT_SECRET'),
            'refreshToken' => env('GOOGLE_DRIVE_REFRESH_TOKEN'),
            'folderId' => env('GOOGLE_DRIVE_FOLDER_ID'),
        ],


        /** 卡牌相關儲存空間 */
        'Cards' => [
            'driver' => 'local',
            'root' => storage_path('app/public/cards'),
            'url' => env('APP_URL').'/storage/cards',
            'visibility' => 'public',
        ],

        /** 活動相關儲存空間 */
        'Events' => [
            'driver' => 'local',
            'root' => storage_path('app/public/events'),
            'url' => env('APP_URL').'/storage/events',
            'visibility' => 'public',
        ],

        /** Banner相關儲存空間 */
        'Banners' => [
            'driver' => 'local',
            'root' => storage_path('app/public/banners'),
            'url' => env('APP_URL').'/storage/banners',
            'visibility' => 'public',
        ],

        /** Deck相關儲存空間 */
        'Decks' => [
            'driver' => 'local',
            'root' => storage_path('app/public/decks'),
            'url' => env('APP_URL').'/storage/decks',
            'visibility' => 'public',
        ],


        /** PTCG 相關儲存空間 */
        'ptcgCardDataSet_EN' => [
            'driver' => 'local',
            'root' => storage_path('app/public/ptcg/dataset/card/en'),
            'url' => env('APP_URL').'/storage/ptcg/dataset/card/en',
            'visibility' => 'public',
        ],
        'ptcgSetDataSet' => [
            'driver' => 'local',
            'root' => storage_path('app/public/ptcg/dataset/set'),
            'url' => env('APP_URL').'/storage/ptcg/dataset/set',
            'visibility' => 'public',
        ],
        'ptcgCardDataSet_TW' => [
            'driver' => 'local',
            'root' => storage_path('app/public/ptcg/dataset/card/tw'),
            'url' => env('APP_URL').'/storage/ptcg/dataset/card/tw',
            'visibility' => 'public',
        ],
        'ptcgCardDataSet_JP' => [
            'driver' => 'local',
            'root' => storage_path('app/public/ptcg/dataset/card/jp'),
            'url' => env('APP_URL').'/storage/ptcg/dataset/card/jp',
            'visibility' => 'public',
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
