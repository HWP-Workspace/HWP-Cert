<?php

/** ติดตั้ง/อัปเดตระบบ — ใช้งานได้เฉพาะตอนที่ระบบยังไม่ได้ติดตั้ง */
final class InstallController
{
    const PASSWORD_MIN_LENGTH = 8;

    public static function routes()
    {
        return [
            'check'   => ['POST', [self::class, 'check']],
            'install' => ['POST', [self::class, 'install']],
        ];
    }

    /** ทดสอบการเชื่อมต่อ และบอกว่าต้องสร้างผู้ดูแลระบบใหม่หรือไม่ */
    public static function check()
    {
        if (!self::editableState()['canEditDatabase']) {
            throw HttpException::forbidden('ไม่สามารถแก้ไขข้อมูลฐานข้อมูลได้');
        }
        Response::json(['ok' => true] + Installer::inspect(self::databaseInput()));
    }

    public static function install()
    {
        $state = self::editableState();

        Installer::install(
            $state['canEditDatabase'] ? self::databaseInput() : null,
            function () {
                return self::setupInput();
            }
        );

        if (!$state['canEditDatabase']) {
            Session::flash('success', 'อัปเดตฐานข้อมูลสำเร็จ');
            Response::success('อัปเดตฐานข้อมูลสำเร็จ', ['redirect' => 'admin.php']);
        }
        Session::flash('success', 'ติดตั้งระบบสำเร็จ กรุณาเข้าสู่ระบบ');
        Response::success('ติดตั้งระบบสำเร็จ', ['redirect' => 'login.php']);
    }

    /** ติดตั้งแล้ว → 404 / โหมดอัปเดต → ต้องเป็นผู้ดูแลระบบสูงสุด */
    private static function editableState()
    {
        $state = Installer::state();
        if ($state['installed']) {
            throw HttpException::notFound();
        }
        if (!$state['canEditDatabase']) {
            Auth::authorizeSuperAdmin();
        }
        return $state;
    }

    private static function databaseInput()
    {
        $name = Request::requiredString('db_name', 'ชื่อฐานข้อมูล', 64);
        if (!preg_match('/^[A-Za-z0-9_\-]+$/', $name)) {
            throw HttpException::badRequest('ชื่อฐานข้อมูลใช้ได้เฉพาะภาษาอังกฤษ ตัวเลข _ และ -');
        }

        return [
            'host'    => Request::requiredString('db_host', 'Host ฐานข้อมูล', 255),
            'port'    => Request::intInRange('db_port', 'Port ฐานข้อมูล', 1, 65535),
            'name'    => $name,
            'user'    => Request::requiredString('db_user', 'ชื่อผู้ใช้ฐานข้อมูล', 255),
            'pass'    => Request::string('db_pass', 255),
            'charset' => 'utf8',
        ];
    }

    private static function setupInput()
    {
        $password = Request::string('admin_password', 72);
        if (mb_strlen($password) < self::PASSWORD_MIN_LENGTH) {
            throw HttpException::badRequest('รหัสผ่านต้องมีอย่างน้อย ' . self::PASSWORD_MIN_LENGTH . ' ตัวอักษร');
        }
        if (!hash_equals($password, Request::string('admin_password_confirmation', 72))) {
            throw HttpException::badRequest('รหัสผ่านไม่ตรงกัน');
        }

        $logo = Request::file('logo', Logo::MAX_BYTES);

        return [
            'school_name'          => Request::requiredString('school_name', 'ชื่อหน่วยงาน/โรงเรียน'),
            'school_shortname'     => Request::requiredString('school_shortname', 'ชื่อย่อหน่วยงาน/โรงเรียน', 10),
            'department_name'      => Request::requiredString('department_name', 'ชื่อกลุ่ม/งานหลัก'),
            'department_shortname' => Request::requiredString('department_shortname', 'ชื่อย่อกลุ่ม/งานหลัก', 50),
            'admin_name'           => Request::requiredString('admin_name', 'ชื่อผู้ดูแลระบบ', 100),
            'admin_password'       => $password,
            'logo'                 => $logo !== null ? Logo::prepare($logo) : null,
        ];
    }
}
