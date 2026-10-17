<?php

final class AuthController
{
    public static function routes()
    {
        return [
            'login' => ['POST', [self::class, 'login']],
        ];
    }

    public static function login()
    {
        $username = Request::string('username', 20);
        $password = Request::string('password', 72);
        if ($username === '' || $password === '') {
            throw HttpException::badRequest('กรุณากรอกชื่อผู้ใช้ และรหัสผ่าน');
        }

        $throttle = new LoginThrottle($username);
        $wait = $throttle->secondsUntilUnlocked();
        if ($wait > 0) {
            throw new HttpException(429, 'เข้าสู่ระบบผิดเกินจำนวนครั้งที่กำหนด กรุณารอ ' . ceil($wait / 60) . ' นาที');
        }

        if (!Auth::attempt($username, $password)) {
            $throttle->hit();
            throw HttpException::badRequest('ชื่อผู้ใช้ หรือ รหัสผ่านไม่ถูกต้อง');
        }

        $throttle->clear();
        Response::success('เข้าสู่ระบบสำเร็จ', ['redirect' => 'admin.php']);
    }
}
