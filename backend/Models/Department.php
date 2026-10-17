<?php

/**
 * ตาราง dp — กลุ่มสาระ/งาน
 */
final class Department
{
    public static function all()
    {
        return Database::fetchAll('SELECT id, name, shortdp FROM dp ORDER BY id');
    }

    public static function find($id)
    {
        return Database::fetch('SELECT id, name, shortdp FROM dp WHERE id = ?', [$id]);
    }

    public static function exists($id)
    {
        return Database::value('SELECT 1 FROM dp WHERE id = ?', [$id]) !== null;
    }

    public static function create($name, $shortName)
    {
        return Database::insert('INSERT INTO dp (name, shortdp) VALUES (?, ?)', [$name, $shortName]);
    }

    public static function update($id, $name, $shortName)
    {
        Database::execute('UPDATE dp SET name = ?, shortdp = ? WHERE id = ?', [$name, $shortName, $id]);
    }

    public static function delete($id)
    {
        Database::execute('DELETE FROM dp WHERE id = ?', [$id]);
    }

    /** ลบได้เมื่อไม่ใช่กลุ่มหลัก และไม่มีผู้ดูแล/โครงการผูกอยู่ */
    public static function isDeletable($id, $adminCount, $projectCount)
    {
        return (int) $id !== Auth::ROOT_DEPARTMENT_ID && (int) $adminCount === 0 && (int) $projectCount === 0;
    }
}
