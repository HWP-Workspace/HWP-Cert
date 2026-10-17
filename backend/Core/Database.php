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
            $dsn = sprintf(
                'mysql:host=%s;dbname=%s;charset=%s',
                Config::get('db.host'),
                Config::get('db.name'),
                Config::get('db.charset', 'utf8')
            );

            self::$pdo = new PDO($dsn, Config::get('db.user'), Config::get('db.pass'), [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ]);
        }
        return self::$pdo;
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
