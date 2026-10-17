<?php
/**
 * จุดเริ่มต้นของทุก request: โหลด config, autoload class, ตั้งค่า error/session/security header
 */

define('BASE_PATH', dirname(__DIR__));
define('BACKEND_PATH', BASE_PATH . '/backend');
define('FRONTEND_PATH', BASE_PATH . '/frontend');
define('PUBLIC_PATH', BASE_PATH . '/public');
define('STORAGE_PATH', BASE_PATH . '/storage');

if (PHP_VERSION_ID < 80200) {
    http_response_code(500);
    exit('ระบบต้องการ PHP 8.2 ขึ้นไป (ปัจจุบัน ' . PHP_VERSION . ')');
}

$missingExtensions = array_filter(['pdo_mysql', 'gd', 'mbstring', 'zip', 'fileinfo', 'xml', 'dom', 'xmlreader', 'zlib'], function ($extension) {
    return !extension_loaded($extension);
});
if ($missingExtensions) {
    http_response_code(500);
    exit('กรุณาเปิดใช้งาน PHP extension ใน php.ini: ' . implode(', ', $missingExtensions));
}

require BASE_PATH . '/vendor/autoload.php';

spl_autoload_register(function ($class) {
    foreach (['Core', 'Models', 'Services', 'Controllers'] as $directory) {
        $file = BACKEND_PATH . "/$directory/$class.php";
        if (is_file($file)) {
            require $file;
            return;
        }
    }
});

require BACKEND_PATH . '/helpers.php';

// ค่าใน config/config.php (สร้างจากหน้าติดตั้ง) ทับค่าเริ่มต้นใน config.example.php
$config = require BASE_PATH . '/config/config.example.php';
if (is_file(Installer::CONFIG_FILE)) {
    $config = array_replace_recursive($config, require Installer::CONFIG_FILE);
}
Config::load($config);

date_default_timezone_set(Config::get('app.timezone'));
error_reporting(E_ALL);
ini_set('display_errors', Config::get('app.debug') ? '1' : '0');
ini_set('log_errors', '1');

// error ที่ไม่ได้ดักไว้ในหน้าเว็บ: บันทึก log และแสดงข้อความทั่วไป (ไม่เปิดเผยรายละเอียดระบบ)
set_exception_handler(function ($e) {
    error_log((string) $e);
    $isHttp = $e instanceof HttpException;
    http_response_code($isHttp ? $e->getStatus() : 500);
    echo $isHttp || Config::get('app.debug') ? e($e->getMessage()) : 'พบข้อผิดพลาดภายในระบบ กรุณาติดต่อผู้ดูแลระบบ';
});

header('X-Frame-Options: SAMEORIGIN');
header('X-Content-Type-Options: nosniff');
header('Referrer-Policy: strict-origin-when-cross-origin');

Session::start();

// ระบบยังไม่ได้ติดตั้ง หรือมี migration ใหม่ → ไปหน้าติดตั้ง (หน้า install.php กำหนด INSTALLER ไว้ก่อน require ไฟล์นี้)
if (!defined('INSTALLER') && !Installer::isInstalled()) {
    if (basename(dirname($_SERVER['SCRIPT_FILENAME'])) === 'api') {
        Response::error('ระบบยังไม่ได้ติดตั้ง กรุณาเปิดหน้า install.php', 503);
    }
    redirect('install.php');
}
