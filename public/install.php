<?php
/**
 * หน้าติดตั้ง/อัปเดตระบบ — เปิดได้เฉพาะตอนที่ระบบยังไม่ได้ติดตั้ง หรือมี migration ใหม่
 */
const INSTALLER = true;
require __DIR__ . '/../backend/bootstrap.php';

$state = Installer::state();
if ($state['installed']) {
    redirect('index.php');
}

View::page('install', [
    'pageTitle'    => 'ติดตั้งระบบ',
    'state'        => $state,
    'requirements' => Installer::requirements($state['canEditDatabase']),
    'database'     => Config::get('db'),
]);
