<?php

/**
 * ตาราง admin — ผู้ดูแลระบบ
 */
final class Admin
{
    public static function find($id)
    {
        return Database::fetch(
            'SELECT a.id, a.username, a.name, a.iddp, d.name AS dp_name, d.shortdp
             FROM admin a LEFT JOIN dp d ON d.id = a.iddp
             WHERE a.id = ?',
            [$id]
        );
    }

    /** รวมคอลัมน์ password — ใช้สำหรับตรวจสอบการล็อกอินเท่านั้น */
    public static function findByUsername($username)
    {
        return Database::fetch('SELECT id, username, password FROM admin WHERE username = ?', [$username]);
    }

    public static function usernameExists($username)
    {
        return Database::value('SELECT 1 FROM admin WHERE username = ?', [$username]) !== null;
    }

    public static function count()
    {
        return (int) Database::value('SELECT COUNT(*) FROM admin');
    }

    public static function create($username, $password, $name, $departmentId)
    {
        return Database::insert(
            'INSERT INTO admin (username, password, name, iddp) VALUES (?, ?, ?, ?)',
            [$username, Auth::hashPassword($password), $name, $departmentId]
        );
    }

    public static function update($id, $name, $departmentId)
    {
        Database::execute('UPDATE admin SET name = ?, iddp = ? WHERE id = ?', [$name, $departmentId, $id]);
    }

    public static function updatePassword($id, $password)
    {
        Database::execute('UPDATE admin SET password = ? WHERE id = ?', [Auth::hashPassword($password), $id]);
    }

    public static function delete($id)
    {
        Database::execute('DELETE FROM admin WHERE id = ?', [$id]);
    }
}
