<?php

/**
 * ติดตั้ง/อัปเดตระบบ: ตรวจสอบความพร้อม, สร้างฐานข้อมูล, รัน migration, สร้างข้อมูลเริ่มต้น และเขียน config/config.php
 *
 * เมื่อติดตั้งเสร็จจะสร้างไฟล์ storage/installed.lock (เก็บชื่อ migration ล่าสุด)
 * - ไม่มีไฟล์ lock หรือมี migration ใหม่ → ทุกหน้าจะพาไปที่ install.php
 * - ต้องการตั้งค่าฐานข้อมูลใหม่ → ลบ storage/installed.lock แล้วเปิด install.php
 */
final class Installer
{
    const CONFIG_FILE = BASE_PATH . '/config/config.php';
    const LOCK_FILE = STORAGE_PATH . '/installed.lock';

    public static function isInstalled()
    {
        return is_file(self::LOCK_FILE) && trim((string) file_get_contents(self::LOCK_FILE)) === Migrator::latest();
    }

    /**
     * @return array [
     *   'installed'       => ติดตั้งเสร็จแล้ว (ห้ามเข้าหน้าติดตั้ง),
     *   'canEditDatabase' => แก้ไขข้อมูลฐานข้อมูลได้ (ยังไม่มี config, เชื่อมต่อไม่ได้ หรือยังไม่มีผู้ดูแลระบบ),
     *   'needsSetup'      => ต้องกรอกข้อมูลหน่วยงานและผู้ดูแลระบบ (ยังไม่มีผู้ดูแลระบบ),
     *   'error'           => ข้อความเมื่อเชื่อมต่อฐานข้อมูลไม่ได้,
     * ]
     */
    public static function state()
    {
        if (self::isInstalled()) {
            return ['installed' => true, 'canEditDatabase' => false, 'needsSetup' => false, 'error' => null];
        }

        $hasAdmin = false;
        $error = null;
        if (is_file(self::CONFIG_FILE)) {
            try {
                $hasAdmin = self::hasAdmin();
            } catch (PDOException $e) {
                $error = 'เชื่อมต่อฐานข้อมูลตาม config/config.php ไม่ได้: ' . $e->getMessage();
            }
        }

        return [
            'installed'       => false,
            'canEditDatabase' => !$hasAdmin,
            'needsSetup'      => !$hasAdmin,
            'error'           => $error,
        ];
    }

    /**
     * @param bool $writesConfig ต้องเขียน config/config.php หรือไม่
     * @return array[] [['label' => ..., 'ok' => bool], ...]
     */
    public static function requirements($writesConfig = true)
    {
        $writable = [
            'storage/uploads/templates' => STORAGE_PATH . '/uploads/templates',
            'storage/uploads/previews'  => STORAGE_PATH . '/uploads/previews',
            'storage/throttle'          => STORAGE_PATH . '/throttle',
            'public/assets/img/fav.ico' => PUBLIC_PATH . '/assets/img/fav.ico',
        ];
        if ($writesConfig) {
            $writable = ['config/' => BASE_PATH . '/config'] + $writable;
        }

        $checks = [['label' => 'PHP ' . PHP_VERSION . ' (ต้องการ 8.2 ขึ้นไป)', 'ok' => PHP_VERSION_ID >= 80200]];
        foreach ($writable as $label => $path) {
            $checks[] = ['label' => "เขียนไฟล์ได้: $label", 'ok' => is_writable($path)];
        }
        return $checks;
    }

    /**
     * ตรวจสอบการเชื่อมต่อฐานข้อมูลที่ผู้ใช้กรอก (ก่อนติดตั้งจริง)
     *
     * @return array ['databaseExists' => bool, 'hasAdmin' => มีข้อมูลเดิมอยู่แล้ว (อัปเดตโดยไม่ต้องสร้างผู้ดูแลใหม่)]
     */
    public static function inspect(array $database)
    {
        try {
            Database::useConnection(Database::connect($database));
        } catch (PDOException $e) {
            if ((int) $e->errorInfo[1] === 1049) { // 1049 = Unknown database
                Database::connect($database, false); // ตรวจว่าเชื่อมต่อเซิร์ฟเวอร์ได้
                return ['databaseExists' => false, 'hasAdmin' => false];
            }
            throw HttpException::badRequest('เชื่อมต่อฐานข้อมูลไม่ได้: ' . $e->getMessage());
        }
        return ['databaseExists' => true, 'hasAdmin' => self::hasAdmin()];
    }

    /**
     * @param array|null $database   ข้อมูลเชื่อมต่อฐานข้อมูล (null = ใช้ค่าจาก config เดิม)
     * @param callable   $setupInput คืนข้อมูลหน่วยงาน/ผู้ดูแลระบบ — เรียกเฉพาะเมื่อฐานข้อมูลยังไม่มีผู้ดูแลระบบ
     */
    public static function install($database, callable $setupInput)
    {
        foreach (self::requirements($database !== null) as $requirement) {
            if (!$requirement['ok']) {
                throw HttpException::badRequest('ระบบยังไม่พร้อม: ' . $requirement['label']);
            }
        }

        if ($database !== null) {
            Database::useConnection(self::connectOrCreate($database));
        }

        // ตรวจข้อมูลก่อนแก้ไขฐานข้อมูล — ฐานข้อมูลเดิมที่มีผู้ดูแลระบบแล้วจะไม่สร้างข้อมูลเริ่มต้นซ้ำ
        $setup = self::hasAdmin() ? null : $setupInput();

        Migrator::migrate();
        if ($setup !== null) {
            self::seed($setup);
        }
        if ($database !== null) {
            self::writeConfig($database);
        }

        file_put_contents(self::LOCK_FILE, Migrator::latest(), LOCK_EX);
    }

    private static function hasAdmin()
    {
        return Database::value("SHOW TABLES LIKE 'admin'") !== null
            && (int) Database::value('SELECT COUNT(*) FROM admin') > 0;
    }

    /** เชื่อมต่อฐานข้อมูล — ถ้ายังไม่มีฐานข้อมูลจะสร้างให้ (หากผู้ใช้มีสิทธิ์) */
    private static function connectOrCreate(array $database)
    {
        try {
            return Database::connect($database);
        } catch (PDOException $e) {
            if ((int) $e->errorInfo[1] !== 1049) { // 1049 = Unknown database
                throw HttpException::badRequest('เชื่อมต่อฐานข้อมูลไม่ได้: ' . $e->getMessage());
            }
        }

        try {
            Database::connect($database, false)->exec(
                'CREATE DATABASE `' . $database['name'] . '` CHARACTER SET utf8 COLLATE utf8_general_ci'
            );
            return Database::connect($database);
        } catch (PDOException $e) {
            throw HttpException::badRequest('ไม่พบฐานข้อมูล และไม่สามารถสร้างได้: ' . $e->getMessage());
        }
    }

    /** ข้อมูลเริ่มต้น: หน่วยงาน, กลุ่ม/งานหลัก (id = 1 เห็นทุกโครงการ) และผู้ดูแลระบบสูงสุด */
    private static function seed(array $setup)
    {
        if (Database::value('SELECT COUNT(*) FROM school') > 0) {
            School::update($setup['school_name'], $setup['school_shortname']);
        } else {
            Database::execute('INSERT INTO school (name, shortname) VALUES (?, ?)', [$setup['school_name'], $setup['school_shortname']]);
        }

        if (!Department::exists(Auth::ROOT_DEPARTMENT_ID)) {
            Database::execute(
                'INSERT INTO dp (id, name, shortdp) VALUES (?, ?, ?)',
                [Auth::ROOT_DEPARTMENT_ID, $setup['department_name'], $setup['department_shortname']]
            );
        }

        Admin::create(Auth::SUPER_ADMIN_USERNAME, $setup['admin_password'], $setup['admin_name'], Auth::ROOT_DEPARTMENT_ID);
    }

    /** เขียน config/config.php โดยคงค่าอื่นที่เคยตั้งไว้ */
    private static function writeConfig(array $database)
    {
        $config = is_file(self::CONFIG_FILE) ? require self::CONFIG_FILE : [];
        $config['db'] = $database;

        $content = "<?php\n"
            . "// สร้างโดยหน้าติดตั้งระบบเมื่อ " . date('Y-m-d H:i:s') . " — ค่าที่ไม่ได้ระบุจะใช้จาก config.example.php\n"
            . 'return ' . var_export($config, true) . ";\n";

        if (file_put_contents(self::CONFIG_FILE, $content, LOCK_EX) === false) {
            throw new RuntimeException('Cannot write ' . self::CONFIG_FILE);
        }
    }
}
