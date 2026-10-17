<?php
return [
    'db' => [
        'host'    => 'localhost',
        'name'    => 'cert',
        'user'    => 'root',
        'pass'    => '',
        'charset' => 'utf8',
    ],

    'app' => [
        'version'  => '4.0.0',
        'timezone' => 'Asia/Bangkok',
        'debug'    => false,
    ],

    'session' => [
        'name'         => 'HWPCERT_SESSION',
        'idle_timeout' => 7200,
    ],

    'login' => [
        'max_attempts'    => 5,
        'lockout_seconds' => 900,
    ],
];
