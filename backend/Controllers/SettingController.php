<?php

/** ตั้งค่าข้อมูลหน่วยงาน/โรงเรียน — เฉพาะผู้ดูแลระบบสูงสุด */
final class SettingController
{
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

        $logo = Request::file('logo', Logo::MAX_BYTES);
        if ($logo !== null) {
            Logo::store($logo);
        }

        School::update($name, $shortName);
        Response::success('แก้ไขข้อมูลระบบสำเร็จ');
    }
}
