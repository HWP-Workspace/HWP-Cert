<?php
/**
 * หน้าติดตั้ง/อัปเดตระบบ
 * - ติดตั้งแล้ว: ตอบ 404 เหมือนไม่มีไฟล์นี้ (ป้องกันการตั้งค่าระบบใหม่โดยผู้ไม่หวังดี)
 * - โหมดอัปเดต (มีผู้ดูแลระบบแล้ว): ต้องล็อกอินเป็นผู้ดูแลระบบสูงสุด
 * - ติดตั้งครั้งแรก: เปิดได้จนกว่าจะติดตั้งเสร็จ
 */
const INSTALLER = true;
require __DIR__ . '/../backend/bootstrap.php';

$state = Installer::state();
if ($state['installed']) {
    http_response_code(404);
    exit;
}

$isUpgrade = !$state['canEditDatabase'];
if ($isUpgrade && !Auth::isSuperAdmin()) {
    if (!Auth::check()) {
        Session::flash('warning', 'ระบบมีการอัปเดตฐานข้อมูล กรุณาเข้าสู่ระบบด้วยบัญชีผู้ดูแลระบบสูงสุด');
        redirect('login.php');
    }
    http_response_code(503);
    View::page('maintenance', ['pageTitle' => 'ระบบกำลังอัปเดต']);
    exit;
}

View::page('install', [
    'pageTitle'    => 'ติดตั้งระบบ',
    'state'        => $state,
    'requirements' => Installer::requirements($state['canEditDatabase']),
    'database'     => Config::get('db'),
]);
