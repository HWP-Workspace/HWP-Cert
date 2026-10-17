<?php

/**
 * PDO wrapper — ทุก query ต้องผ่าน prepared statement เพื่อป้องกัน SQL injection
 */
final class Database
{
    private static $pdo;

    public static function connection()
    {
        if (self::$pdo === null) {
            self::$pdo = self::connect(Config::get('db'));
        }
        return self::$pdo;
    }

    /**
     * เชื่อมต่อฐานข้อมูลจากค่าที่กำหนด (ใช้ตอนติดตั้งระบบ ก่อนมีไฟล์ config)
     *
     * @param array $db ['host', 'port', 'name', 'user', 'pass', 'charset']
     * @param bool  $selectDatabase false = เชื่อมต่อเฉพาะเซิร์ฟเวอร์ (สำหรับสร้างฐานข้อมูล)
     */
    public static function connect(array $db, $selectDatabase = true)
    {
        $dsn = sprintf(
            'mysql:host=%s;port=%d;charset=%s',
            $db['host'],
            isset($db['port']) ? (int) $db['port'] : 3306,
            isset($db['charset']) ? $db['charset'] : 'utf8'
        );
        if ($selectDatabase) {
            $dsn .= ';dbname=' . $db['name'];
        }

        return new PDO($dsn, $db['user'], $db['pass'], [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
            PDO::ATTR_TIMEOUT            => 5,
        ]);
    }

    /** ใช้ connection ที่สร้างไว้แล้ว (ตอนติดตั้งระบบ) */
    public static function useConnection(PDO $pdo)
    {
        self::$pdo = $pdo;
    }

    public static function query($sql, array $params = [])
    {
        $statement = self::connection()->prepare($sql);
        $statement->execute($params);
        return $statement;
    }

    /** แถวแรก หรือ null ถ้าไม่พบ */
    public static function fetch($sql, array $params = [])
    {
        $row = self::query($sql, $params)->fetch();
        return $row === false ? null : $row;
    }

    public static function fetchAll($sql, array $params = [])
    {
        return self::query($sql, $params)->fetchAll();
    }

    /** ค่าคอลัมน์แรกของแถวแรก หรือ null ถ้าไม่พบ */
    public static function value($sql, array $params = [])
    {
        $value = self::query($sql, $params)->fetchColumn();
        return $value === false ? null : $value;
    }

    /** คืนค่าจำนวนแถวที่ได้รับผลกระทบ */
    public static function execute($sql, array $params = [])
    {
        return self::query($sql, $params)->rowCount();
    }

    /** คืนค่า id ของแถวที่เพิ่ม */
    public static function insert($sql, array $params = [])
    {
        self::query($sql, $params);
        return (int) self::connection()->lastInsertId();
    }

    public static function transaction(callable $callback)
    {
        $pdo = self::connection();
        $pdo->beginTransaction();
        try {
            $result = $callback();
            $pdo->commit();
            return $result;
        } catch (Throwable $e) {
            $pdo->rollBack();
            throw $e;
        }
    }
}
