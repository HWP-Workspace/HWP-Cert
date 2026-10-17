<?php

/**
 * เรียก handler ตาม ?action= และแปลง exception เป็น JSON response
 *
 *   Api::dispatch([
 *       'list'   => ['GET',  [ProjectController::class, 'list']],
 *       'create' => ['POST', [ProjectController::class, 'create']],
 *   ]);
 *
 * ทุก action แบบ POST จะตรวจสอบ CSRF token ก่อนเสมอ
 */
final class Api
{
    public static function dispatch(array $routes)
    {
        try {
            $action = (string) Request::input('action', '');
            if (!isset($routes[$action])) {
                throw HttpException::notFound('ไม่พบคำสั่งที่เรียกใช้');
            }

            list($method, $handler) = $routes[$action];
            if (Request::method() !== $method) {
                throw new HttpException(405, 'ท่านเรียกใช้งานไม่ถูกต้อง');
            }
            if ($method === 'POST') {
                Csrf::verify();
            }

            $handler();
        } catch (HttpException $e) {
            Response::error($e->getMessage(), $e->getStatus(), $e->getData());
        } catch (Throwable $e) {
            error_log((string) $e);
            $message = Config::get('app.debug') ? $e->getMessage() : 'พบข้อผิดพลาดภายในระบบ กรุณาติดต่อผู้ดูแลระบบ';
            Response::error($message, 500);
        }
    }
}
