<?php
// ใช้งานได้ระหว่างรออัปเดตฐานข้อมูล เพื่อให้ผู้ดูแลระบบสูงสุดล็อกอินไปกดอัปเดตได้
const AVAILABLE_DURING_UPGRADE = true;
require __DIR__ . '/../backend/bootstrap.php';

if (Auth::check()) {
    redirect('admin.php');
}

View::page('login');
