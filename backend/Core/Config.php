<?php

final class Config
{
    private static $items = [];

    public static function load(array $items)
    {
        self::$items = $items;
    }

    /**
     * อ่านค่าแบบ dot notation เช่น Config::get('db.host')
     */
    public static function get($key, $default = null)
    {
        $value = self::$items;
        foreach (explode('.', $key) as $segment) {
            if (!is_array($value) || !array_key_exists($segment, $value)) {
                return $default;
            }
            $value = $value[$segment];
        }
        return $value;
    }
}
