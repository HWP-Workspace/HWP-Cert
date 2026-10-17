<?php
/**
 * ใช้เมื่อ Document Root ชี้มาที่โฟลเดอร์หลัก บนเซิร์ฟเวอร์ที่ไม่อ่าน .htaccess (เช่น Nginx / Plesk)
 * — ส่งต่อไปยัง public/ (แนะนำให้ตั้ง Document Root เป็นโฟลเดอร์ public/ แทน)
 */
header('Location: public/', true, 302);
