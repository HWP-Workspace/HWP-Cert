<?php

/**
 * แสดงผลหน้าเว็บจาก template ในโฟลเดอร์ frontend/
 */
final class View
{
    /**
     * แสดงหน้า frontend/pages/{$name}.php โดยส่ง $data เป็นตัวแปรให้ template
     *
     * ค่า $data['page'] ใช้กำหนด layout: active, back, modals, scripts, data
     * (ดู frontend/layouts/sidebar.php และ frontend/layouts/end.php)
     */
    public static function page($name, array $data = [])
    {
        extract($data, EXTR_SKIP);
        require FRONTEND_PATH . '/pages/' . $name . '.php';
    }
}
