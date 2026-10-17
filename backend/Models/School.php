<?php

/**
 * ตาราง school — ข้อมูลหน่วยงาน/โรงเรียน (มีแถวเดียว)
 */
final class School
{
    private static $cache;

    public static function get()
    {
        if (self::$cache === null) {
            self::$cache = Database::fetch('SELECT name, shortname FROM school ORDER BY id LIMIT 1')
                ?: ['name' => '', 'shortname' => ''];
        }
        return self::$cache;
    }

    public static function name()
    {
        return self::get()['name'];
    }

    public static function update($name, $shortName)
    {
        Database::execute('UPDATE school SET name = ?, shortname = ?', [$name, $shortName]);
        self::$cache = null;
    }
}
