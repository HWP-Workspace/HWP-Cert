<?php
/**
 * ฟังก์ชันช่วยที่ใช้ทั่วทั้งระบบ
 */

/** Escape ข้อความก่อนแสดงผลใน HTML ป้องกัน XSS */
function e($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/**
 * URL path ของโฟลเดอร์ public/ ตามที่เบราว์เซอร์ต้องใช้ เช่น "/" (Document Root = public/)
 * หรือ "/public/" (Document Root = โฟลเดอร์หลัก) — ใช้ SCRIPT_NAME เพราะเป็น path จริงของไฟล์
 * แม้ request จะถูก rewrite มาจาก .htaccess (กรณี Plesk ที่ Nginx รัน .php เองแต่ส่ง / ให้ Apache)
 */
function base_url()
{
    $directory = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
    if (basename(dirname($_SERVER['SCRIPT_FILENAME'])) === 'api') {
        $directory = dirname($directory);
    }
    return rtrim($directory, '/') . '/';
}

/** redirect — URL แบบ relative (เช่น 'admin.php') จะอ้างอิงจากโฟลเดอร์ public/ เสมอ */
function redirect($url)
{
    if (!preg_match('#^(https?:)?/#', $url)) {
        $url = base_url() . $url;
    }
    header('Location: ' . $url);
    exit;
}

/** แปลงวันที่เป็นรูปแบบไทยแบบย่อ เช่น 3 ม.ค. 2565 */
function thai_date($date)
{
    static $months = ['', 'ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'];

    $time = strtotime($date);
    if ($time === false) {
        return '';
    }
    return date('j', $time) . ' ' . $months[(int) date('n', $time)] . ' ' . thai_year($date);
}

/** ปี พ.ศ. ของวันที่ที่ระบุ (ค่าเริ่มต้นคือปีปัจจุบัน) */
function thai_year($date = 'now')
{
    return (int) date('Y', strtotime($date)) + 543;
}

/** แปลงเลขอารบิกเป็นเลขไทย */
function thai_digits($value)
{
    return strtr((string) $value, ['0' => '๐', '1' => '๑', '2' => '๒', '3' => '๓', '4' => '๔', '5' => '๕', '6' => '๖', '7' => '๗', '8' => '๘', '9' => '๙']);
}

/**
 * ปุ่มในคอลัมน์ "ดำเนินการ" ของ DataTable — JavaScript จับคลิกจาก data-action
 *
 * @param string $style primary | warning | danger ...
 */
function action_button($action, $id, $style, $icon, $title, $enabled = true)
{
    return sprintf(
        '<button type="button" class="btn btn-sm btn-%s mr-1" data-action="%s" data-id="%d" title="%s"%s><i class="%s"></i></button>',
        e($style),
        e($action),
        (int) $id,
        e($title),
        $enabled ? '' : ' disabled',
        e($icon)
    );
}

/** URL เต็มของ request ปัจจุบัน (ใช้สร้าง QR code) */
function current_url()
{
    $scheme = Request::isHttps() ? 'https' : 'http';
    return $scheme . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
}
