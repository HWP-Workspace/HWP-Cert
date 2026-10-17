<?php

/**
 * CSRF token ผูกกับ session — ทุก request ที่เปลี่ยนแปลงข้อมูล (POST) ต้องส่ง token นี้มาด้วย
 * ผ่าน header X-CSRF-Token (AJAX) หรือ field _token (form)
 */
final class Csrf
{
    const SESSION_KEY = '_csrf_token';
    const HEADER = 'HTTP_X_CSRF_TOKEN';
    const FIELD = '_token';

    public static function token()
    {
        $token = Session::get(self::SESSION_KEY);
        if (!$token) {
            $token = bin2hex(random_bytes(32));
            Session::set(self::SESSION_KEY, $token);
        }
        return $token;
    }

    /** สร้าง token ใหม่ (เรียกหลังล็อกอิน/ออกจากระบบ) */
    public static function rotate()
    {
        Session::forget(self::SESSION_KEY);
        return self::token();
    }

    public static function field()
    {
        return '<input type="hidden" name="' . self::FIELD . '" value="' . e(self::token()) . '">';
    }

    public static function verify()
    {
        $sent = isset($_SERVER[self::HEADER]) ? $_SERVER[self::HEADER] : (isset($_POST[self::FIELD]) ? $_POST[self::FIELD] : '');
        $expected = Session::get(self::SESSION_KEY);

        if (!$expected || !is_string($sent) || !hash_equals($expected, $sent)) {
            throw HttpException::csrfMismatch();
        }
    }
}
