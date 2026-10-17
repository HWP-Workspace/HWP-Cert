<?php
/**
 * QR code บนเกียรติบัตรที่ออกก่อนย้ายไฟล์ไป public/ ชี้มาที่ /print.php — ส่งต่อพร้อมพารามิเตอร์เดิม
 * (ใช้เฉพาะกรณี Document Root ชี้มาที่โฟลเดอร์หลัก บนเซิร์ฟเวอร์ที่ไม่อ่าน .htaccess)
 */
$query = isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : '';
header('Location: public/print.php' . ($query !== '' ? '?' . $query : ''), true, 301);
