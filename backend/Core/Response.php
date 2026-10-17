<?php

final class Response
{
    public static function json($data, $status = 200)
    {
        http_response_code($status);
        header('Content-Type: application/json; charset=utf-8');
        header('Cache-Control: no-store');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }

    public static function success($message, array $extra = [])
    {
        self::json(['ok' => true, 'message' => $message] + $extra);
    }

    public static function error($message, $status, array $extra = [])
    {
        self::json(['ok' => false, 'message' => $message] + $extra, $status);
    }
}
