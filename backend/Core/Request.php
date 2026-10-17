<?php

/**
 * อ่านและตรวจสอบค่าจาก request — ค่าที่ไม่ผ่านจะโยน HttpException(422) พร้อมข้อความภาษาไทย
 */
final class Request
{
    public static function method()
    {
        return strtoupper(isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : 'GET');
    }

    public static function isHttps()
    {
        return (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
            || (isset($_SERVER['SERVER_PORT']) && (int) $_SERVER['SERVER_PORT'] === 443)
            || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https');
    }

    public static function ip()
    {
        return isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '0.0.0.0';
    }

    public static function input($key, $default = null)
    {
        if (isset($_POST[$key])) {
            return $_POST[$key];
        }
        return isset($_GET[$key]) ? $_GET[$key] : $default;
    }

    /** ข้อความ (trim แล้ว) — ค่าว่างคืน '' */
    public static function string($key, $maxLength = 255)
    {
        $value = self::input($key, '');
        if (!is_scalar($value)) {
            throw HttpException::badRequest('ข้อมูลไม่ถูกต้อง');
        }
        $value = trim((string) $value);
        if (mb_strlen($value) > $maxLength) {
            throw HttpException::badRequest("ข้อมูลยาวเกินกำหนด (ไม่เกิน {$maxLength} ตัวอักษร)");
        }
        return $value;
    }

    public static function requiredString($key, $label, $maxLength = 255)
    {
        $value = self::string($key, $maxLength);
        if ($value === '') {
            throw HttpException::badRequest("กรุณากรอก{$label}");
        }
        return $value;
    }

    /** จำนวนเต็ม — ไม่ใช่ตัวเลขคืน null */
    public static function int($key)
    {
        $value = self::input($key);
        if (is_scalar($value) && preg_match('/^-?\d+$/', (string) $value)) {
            return (int) $value;
        }
        return null;
    }

    public static function requiredId($key = 'id')
    {
        $value = self::int($key);
        if ($value === null || $value <= 0) {
            throw HttpException::badRequest('รหัสอ้างอิงไม่ถูกต้อง');
        }
        return $value;
    }

    public static function intInRange($key, $label, $min, $max)
    {
        $value = self::int($key);
        if ($value === null || $value < $min || $value > $max) {
            throw HttpException::badRequest("{$label}ต้องอยู่ระหว่าง {$min} - {$max}");
        }
        return $value;
    }

    /** วันที่รูปแบบ YYYY-MM-DD */
    public static function date($key, $label)
    {
        $value = self::string($key, 10);
        $date = DateTime::createFromFormat('!Y-m-d', $value);
        if (!$date || $date->format('Y-m-d') !== $value) {
            throw HttpException::badRequest("กรุณาระบุ{$label}ให้ถูกต้อง");
        }
        return $value;
    }

    /** ค่าต้องอยู่ในรายการที่อนุญาต */
    public static function oneOf($key, $label, array $allowed)
    {
        $value = self::string($key);
        if (!in_array($value, array_map('strval', $allowed), true)) {
            throw HttpException::badRequest("{$label}ไม่ถูกต้อง");
        }
        return $value;
    }

    /** ไฟล์ที่อัปโหลดสำเร็จ หรือ null ถ้าไม่ได้เลือกไฟล์ */
    public static function file($key, $maxBytes)
    {
        $file = isset($_FILES[$key]) ? $_FILES[$key] : null;

        if ($file === null || $file['error'] === UPLOAD_ERR_NO_FILE) {
            return null;
        }
        if (is_array($file['error'])) {
            throw HttpException::badRequest('อัปโหลดได้ครั้งละ 1 ไฟล์');
        }
        if ($file['error'] === UPLOAD_ERR_INI_SIZE || $file['error'] === UPLOAD_ERR_FORM_SIZE || $file['size'] > $maxBytes) {
            throw HttpException::badRequest('ไฟล์มีขนาดใหญ่เกิน ' . round($maxBytes / 1048576, 1) . ' MB');
        }
        if ($file['error'] !== UPLOAD_ERR_OK || !is_uploaded_file($file['tmp_name'])) {
            throw HttpException::badRequest('อัปโหลดไฟล์ไม่สำเร็จ กรุณาลองใหม่');
        }
        return $file;
    }
}
