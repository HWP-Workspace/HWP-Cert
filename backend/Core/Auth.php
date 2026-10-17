<?php

final class Auth
{
    /** ผู้ดูแลระบบสูงสุด — เข้าถึงหน้าตั้งค่าระบบได้ */
    const SUPER_ADMIN_USERNAME = 'admin';

    /** ผู้ใช้ในกลุ่ม/งานนี้เห็นและจัดการได้ทุกโครงการ */
    const ROOT_DEPARTMENT_ID = 1;

    const SESSION_USER_ID = '_auth_user_id';
    const SESSION_FINGERPRINT = '_auth_fingerprint';

    /** @var array|null|false false = ยังไม่โหลด */
    private static $user = false;

    /**
     * ตรวจสอบชื่อผู้ใช้/รหัสผ่าน แล้วเริ่ม session ใหม่หากถูกต้อง
     */
    public static function attempt($username, $password)
    {
        $admin = Admin::findByUsername($username);

        // เรียก password_verify เสมอแม้ไม่พบผู้ใช้ เพื่อไม่ให้เวลาตอบสนองบอกได้ว่ามีชื่อผู้ใช้นี้หรือไม่
        $hash = $admin ? $admin['password'] : '$2y$10$usesomesillystringfore7hnbRJHxXVLeakoG8K30oukPsA.ztMG';
        $valid = self::verifyPassword($password, $hash);

        if (!$admin || !$valid) {
            return false;
        }

        if (self::needsRehash($admin['password'])) {
            Admin::updatePassword($admin['id'], $password);
        }

        Session::regenerate();
        Session::set(self::SESSION_USER_ID, (int) $admin['id']);
        Session::set(self::SESSION_FINGERPRINT, self::fingerprint());
        Csrf::rotate();
        self::$user = false;

        return true;
    }

    public static function logout()
    {
        Session::destroy();
        self::$user = null;
    }

    /** ข้อมูลผู้ใช้ที่ล็อกอินอยู่ (โหลดจากฐานข้อมูลทุก request เพื่อให้ผู้ใช้ที่ถูกลบหลุดออกทันที) */
    public static function user()
    {
        if (self::$user !== false) {
            return self::$user;
        }

        self::$user = null;
        $id = Session::get(self::SESSION_USER_ID);
        if (!$id) {
            return null;
        }

        if (!hash_equals((string) Session::get(self::SESSION_FINGERPRINT), self::fingerprint())) {
            self::logout();
            return null;
        }

        self::$user = Admin::find($id);
        if (!self::$user) {
            self::logout();
        }
        return self::$user;
    }

    public static function check()
    {
        return self::user() !== null;
    }

    public static function id()
    {
        $user = self::user();
        return $user ? (int) $user['id'] : null;
    }

    public static function isSuperAdmin()
    {
        $user = self::user();
        return $user !== null && $user['username'] === self::SUPER_ADMIN_USERNAME;
    }

    public static function canSeeAllProjects()
    {
        $user = self::user();
        return $user !== null && (int) $user['iddp'] === self::ROOT_DEPARTMENT_ID;
    }

    public static function canManageProject(array $project)
    {
        $user = self::user();
        return $user !== null
            && (self::canSeeAllProjects() || (int) $project['iddp'] === (int) $user['iddp']);
    }

    /* ---------- Guards สำหรับหน้าเว็บ (redirect) ---------- */

    public static function requireLogin()
    {
        if (!self::check()) {
            redirect('login.php');
        }
    }

    public static function requireSuperAdmin()
    {
        self::requireLogin();
        if (!self::isSuperAdmin()) {
            redirect('admin.php');
        }
    }

    /* ---------- Guards สำหรับ API (exception) ---------- */

    public static function authorize()
    {
        if (!self::check()) {
            throw HttpException::unauthorized();
        }
    }

    public static function authorizeSuperAdmin()
    {
        self::authorize();
        if (!self::isSuperAdmin()) {
            throw HttpException::forbidden();
        }
    }

    /** คืนข้อมูลโครงการหากผู้ใช้มีสิทธิ์จัดการ */
    public static function authorizeProject($projectId)
    {
        self::authorize();
        $project = Project::find($projectId);
        if (!$project) {
            throw HttpException::notFound('ไม่พบโครงการ/กิจกรรม');
        }
        if (!self::canManageProject($project)) {
            throw HttpException::forbidden('ท่านไม่มีสิทธิ์จัดการโครงการ/กิจกรรมนี้');
        }
        return $project;
    }

    /* ---------- Password ---------- */

    public static function hashPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    /**
     * รองรับรหัสผ่านแบบ md5 จากเวอร์ชันเก่า — จะถูกแปลงเป็น password_hash อัตโนมัติเมื่อล็อกอินสำเร็จ
     */
    private static function verifyPassword($password, $hash)
    {
        if (self::isLegacyHash($hash)) {
            return hash_equals($hash, md5($password))
                || hash_equals($hash, md5(self::legacyEscape($password)));
        }
        return password_verify($password, $hash);
    }

    private static function needsRehash($hash)
    {
        return self::isLegacyHash($hash) || password_needs_rehash($hash, PASSWORD_DEFAULT);
    }

    private static function isLegacyHash($hash)
    {
        return strlen($hash) === 32 && ctype_xdigit($hash);
    }

    /** เวอร์ชันเก่า md5 รหัสผ่านหลังผ่าน mysqli_real_escape_string */
    private static function legacyEscape($value)
    {
        return strtr($value, ["\\" => "\\\\", "\0" => "\\0", "\n" => "\\n", "\r" => "\\r", "'" => "\\'", '"' => '\\"', "\x1a" => "\\Z"]);
    }

    private static function fingerprint()
    {
        return hash('sha256', isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '');
    }
}
