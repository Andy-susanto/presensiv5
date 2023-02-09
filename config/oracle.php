<?php

return [
    'oracle' => [
        'driver'         => 'oracle',
        'tns'            => env('DB_TNS_PEGAWAI', ''),
        'host'           => env('DB_HOST_PEGAWAI', ''),
        'port'           => env('DB_PORT_PEGAWAI', '1521'),
        'database'       => env('DB_DATABASE_PEGAWAI', ''),
        'service_name'   => env('DB_SERVICE_NAME_PEGAWAI', ''),
        'username'       => env('DB_USERNAME_PEGAWAI', ''),
        'password'       => env('DB_PASSWORD_PEGAWAI', ''),
        'charset'        => env('DB_CHARSET_PEGAWAI', 'AL32UTF8'),
        'prefix'         => env('DB_PREFIX_PEGAWAI', ''),
        'prefix_schema'  => env('DB_SCHEMA_PREFIX_PEGAWAI', ''),
        'edition'        => env('DB_EDITION_PEGAWAI', 'ora$base'),
        'server_version' => env('DB_SERVER_VERSION_PEGAWAI', '11g'),
        'load_balance'   => env('DB_LOAD_BALANCE_PEGAWAI', 'yes'),
        'dynamic'        => [],
    ],
];
