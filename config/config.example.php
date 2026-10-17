<?php
/**
 * ค่าเริ่มต้นของระบบ — ไฟล์ config/config.php จะถูกสร้างอัตโนมัติจากหน้าติดตั้ง (install.php)
 * ค่าใดที่ไม่ได้ระบุใน config/config.php จะใช้ค่าจากไฟล์นี้
 */
return [
    'db' => [
        'host'    => 'localhost',
        'port'    => 3306,
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
        'name'         => 'CERT_SESSION',
        'idle_timeout' => 7200,
    ],

    'login' => [
        'max_attempts'    => 5,
        'lockout_seconds' => 900,
    ],
];
