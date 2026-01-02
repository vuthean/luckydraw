<?php

return [
    'oracle' => [
        'driver'   => 'oracle',
        'host'     => env('DB_ORACLE_HOST', ''),
        'port'     => env('DB_ORACLE_PORT', ''),
        'database' => env('DB_ORACLE_DATABASE', ''),
        'username' => env('DB_ORACLE_USERNAME', ''),
        'password' => env('DB_ORACLE_PASSWORD', ''),
        'charset'  => '',
        'prefix'   => '',
        // 'tns'            => env('DB_TNS', ''),
        // 'host'           => env('DB_HOST', ''),
        // 'port'           => env('DB_PORT', '1521'),
        // 'database'       => env('DB_DATABASE', ''),
        // 'username'       => env('DB_USERNAME', ''),
        // 'password'       => env('DB_PASSWORD', ''),
        // 'charset'        => env('DB_CHARSET', 'AL32UTF8'),
        // 'prefix'         => env('DB_PREFIX', ''),
        // 'prefix_schema'  => env('DB_SCHEMA_PREFIX', ''),
        // 'edition'        => env('DB_EDITION', 'ora$base'),
        // 'server_version' => env('DB_SERVER_VERSION', '11g'),
    ],
];

      