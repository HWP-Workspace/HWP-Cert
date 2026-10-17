<?php

/**
 * รันไฟล์ migration (database/migrations/*.sql) ตามลำดับชื่อไฟล์
 * ไฟล์ที่รันแล้วจะถูกบันทึกในตาราง `migrations` และจะไม่ถูกรันซ้ำ
 *
 * การเพิ่ม migration ใหม่: สร้างไฟล์ เช่น 002_add_xxx.sql — ระบบจะพาผู้ดูแลไปหน้า install.php เพื่ออัปเดตอัตโนมัติ
 */
final class Migrator
{
    const DIRECTORY = BASE_PATH . '/database/migrations';

    /** ชื่อ migration ทั้งหมดเรียงตามลำดับ */
    public static function all()
    {
        $files = array_map('basename', glob(self::DIRECTORY . '/*.sql') ?: []);
        sort($files, SORT_STRING);
        return $files;
    }

    /** migration ล่าสุด — ใช้เป็นเวอร์ชันของโครงสร้างฐานข้อมูล */
    public static function latest()
    {
        $all = self::all();
        return $all ? end($all) : '';
    }

    /** @return string[] ชื่อ migration ที่รันในครั้งนี้ */
    public static function migrate()
    {
        Database::execute(
            'CREATE TABLE IF NOT EXISTS `migrations` (
                `name` varchar(255) NOT NULL,
                `ran_at` datetime NOT NULL,
                PRIMARY KEY (`name`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8'
        );

        $done = array_column(Database::fetchAll('SELECT name FROM migrations'), 'name');
        $ran = [];

        foreach (array_diff(self::all(), $done) as $migration) {
            foreach (self::statements(file_get_contents(self::DIRECTORY . '/' . $migration)) as $sql) {
                Database::execute($sql);
            }
            Database::execute('INSERT INTO migrations (name, ran_at) VALUES (?, NOW())', [$migration]);
            $ran[] = $migration;
        }
        return $ran;
    }

    /** แยกคำสั่ง SQL ด้วย ; ท้ายบรรทัด และตัดบรรทัด comment ออก */
    private static function statements($sql)
    {
        $sql = preg_replace('/^\s*--.*$/m', '', $sql);
        return array_filter(array_map('trim', preg_split('/;\s*$/m', $sql)));
    }
}
