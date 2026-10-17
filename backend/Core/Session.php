<?php

final class Session
{
    public static function start()
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            return;
        }

        ini_set('session.use_strict_mode', '1');
        ini_set('session.use_only_cookies', '1');

        session_name(Config::get('session.name', 'CERT_SESSION'));
        session_set_cookie_params([
            'lifetime' => 0,
            'path'     => '/',
            'secure'   => Request::isHttps(),
            'httponly' => true,
            'samesite' => 'Lax',
        ]);
        session_start();

        self::expireIdleSession();
    }

    /** ป้องกัน session fixation: ต้องเรียกทุกครั้งที่สถานะการล็อกอินเปลี่ยน */
    public static function regenerate()
    {
        session_regenerate_id(true);
    }

    public static function destroy()
    {
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', [
                'expires'  => time() - 42000,
                'path'     => $params['path'],
                'secure'   => $params['secure'],
                'httponly' => $params['httponly'],
                'samesite' => $params['samesite'],
            ]);
        }
        session_destroy();
    }

    public static function get($key, $default = null)
    {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : $default;
    }

    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public static function forget($key)
    {
        unset($_SESSION[$key]);
    }

    /**
     * ข้อความแจ้งเตือนครั้งเดียว (แสดงในหน้าถัดไปหลัง redirect)
     *
     * @param string $type success | warning | error
     */
    public static function flash($type, $message)
    {
        $_SESSION['_flash'] = ['type' => $type, 'message' => $message];
    }

    public static function pullFlash()
    {
        $flash = self::get('_flash');
        self::forget('_flash');
        return $flash;
    }

    private static function expireIdleSession()
    {
        $timeout = (int) Config::get('session.idle_timeout', 7200);
        $lastActivity = self::get('_last_activity');

        if ($lastActivity !== null && time() - $lastActivity > $timeout) {
            session_unset();
            self::regenerate();
        }
        self::set('_last_activity', time());
    }
}
