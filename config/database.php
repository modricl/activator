<?php

return [
    'activator_database_connection' => [
        'driver' => env('MODRICL_ACTIVATOR_DRIVER', 'mysql'),
        'host' => env('MODRICL_ACTIVATOR_HOST', '127.0.0.1'),
        'port' => env('MODRICL_ACTIVATOR_PORT', '3306'),
        'database' => env('MODRICL_ACTIVATOR_DATABASE', ''),
        'username' => env('MODRICL_ACTIVATOR_USERNAME', ''),
        'password' => env('MODRICL_ACTIVATOR_PASSWORD', ''),
        'charset' => 'utf8',
        'collation' => 'utf8_general_ci',
    ],
];
