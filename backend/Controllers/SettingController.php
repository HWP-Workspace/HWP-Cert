<?php

/** ตั้งค่าข้อมูลหน่วยงาน/โรงเรียน — เฉพาะผู้ดูแลระบบสูงสุด */
final class SettingController
{
    const LOGO_MAX_BYTES = 1048576; // 1 MB
    const LOGO_PATH = PUBLIC_PATH . '/assets/img/fav.ico';

    public static function routes()
    {
        return [
            'get'    => ['GET', [self::class, 'get']],
            'update' => ['POST', [self::class, 'update']],
        ];
    }

    public static function get()
    {
        Auth::authorizeSuperAdmin();
        Response::json(['ok' => true, 'data' => School::get()]);
    }

    public static function update()
    {
        Auth::authorizeSuperAdmin();

        $name = Request::requiredString('name', 'ชื่อหน่วยงาน/โรงเรียน');
        $shortName = Request::requiredString('shortname', 'ชื่อย่อหน่วยงาน/โรงเรียน', 10);

        $logo = Request::file('logo', self::LOGO_MAX_BYTES);
        if ($logo !== null) {
            if (!self::isIcoFile($logo)) {
                throw HttpException::badRequest('ตราสัญลักษณ์ต้องเป็นไฟล์ .ico เท่านั้น');
            }
            move_uploaded_file($logo['tmp_name'], self::LOGO_PATH);
        }

        School::update($name, $shortName);
        Response::success('แก้ไขข้อมูลระบบสำเร็จ');
    }

    /** ตรวจสอบว่าเป็นไฟล์ .ico จริง (ดูจาก header ของไฟล์ ไม่ใช่แค่นามสกุล) */
    private static function isIcoFile(array $file)
    {
        $header = file_get_contents($file['tmp_name'], false, null, 0, 4);
        return strtolower(pathinfo($file['name'], PATHINFO_EXTENSION)) === 'ico' && $header === "\x00\x00\x01\x00";
    }
}
