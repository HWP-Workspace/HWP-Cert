<?php

/**
 * Exception ที่มี HTTP status code และข้อความที่ปลอดภัยสำหรับแสดงให้ผู้ใช้เห็น
 */
class HttpException extends RuntimeException
{
    private $status;
    private $data;

    /**
     * @param array $data ข้อมูลเพิ่มเติมที่ส่งกลับไปใน JSON response
     */
    public function __construct($status, $message, array $data = [])
    {
        parent::__construct($message);
        $this->status = (int) $status;
        $this->data = $data;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getData()
    {
        return $this->data;
    }

    /** CSRF token ไม่ถูกต้อง — ฝั่งหน้าเว็บจะโหลดหน้าใหม่เพื่อรับ token ใหม่ (ใช้ 403 เพราะ Apache ไม่รู้จัก 419) */
    public static function csrfMismatch()
    {
        return new self(403, 'เซสชันหมดอายุหรือ token ไม่ถูกต้อง กรุณารีเฟรชหน้าเว็บแล้วลองใหม่', ['reload' => true]);
    }

    public static function badRequest($message)
    {
        return new self(422, $message);
    }

    public static function unauthorized($message = 'กรุณาเข้าสู่ระบบ')
    {
        return new self(401, $message);
    }

    public static function forbidden($message = 'ท่านไม่มีสิทธิ์ดำเนินการนี้')
    {
        return new self(403, $message);
    }

    public static function notFound($message = 'ไม่พบข้อมูล')
    {
        return new self(404, $message);
    }
}
