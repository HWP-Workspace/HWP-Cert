<?php
// ใช้งานได้ระหว่างรออัปเดตฐานข้อมูล เพื่อให้ผู้ดูแลระบบสูงสุดล็อกอินไปกดอัปเดตได้
const AVAILABLE_DURING_UPGRADE = true;
require __DIR__ . '/../backend/bootstrap.php';

// ออกจากระบบได้เฉพาะ POST พร้อม CSRF token เท่านั้น (ป้องกันการถูกบังคับออกจากระบบผ่านลิงก์)
if (Request::method() === 'POST') {
    try {
        Csrf::verify();
        Auth::logout();
    } catch (HttpException $e) {
        // token ไม่ถูกต้อง — กลับหน้าแรกโดยไม่ออกจากระบบ
    }
}

redirect('index.php');
