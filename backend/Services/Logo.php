<?php

/**
 * ตราสัญลักษณ์หน่วยงาน — รับไฟล์ .png, .jpg หรือ .ico (png/jpg แปลงเป็น .ico ให้อัตโนมัติ)
 * ไฟล์ที่อัปโหลดเก็บที่ public/uploads/logo.ico (ไม่อยู่ใน git) — ถ้ายังไม่มีจะใช้โลโก้เริ่มต้นของระบบ
 */
final class Logo
{
    const PATH = PUBLIC_PATH . '/uploads/logo.ico';
    const DEFAULT_URL = 'assets/img/default-logo.ico';
    const MAX_BYTES = 2097152; // 2 MB
    const SIZE = 256;           // ขนาดสูงสุดที่ไฟล์ .ico รองรับ

    /** URL สำหรับแสดงผล (มีเลขเวอร์ชันเพื่อไม่ให้เบราว์เซอร์ใช้ไฟล์เก่าจาก cache) */
    public static function url()
    {
        return is_file(self::PATH) ? 'uploads/logo.ico?v=' . filemtime(self::PATH) : self::DEFAULT_URL;
    }

    /**
     * ตรวจสอบไฟล์และแปลงเป็นข้อมูล .ico (ยังไม่บันทึก — ใช้ตรวจก่อนติดตั้งระบบ)
     *
     * @return string ข้อมูลไฟล์ .ico
     */
    public static function prepare(array $file)
    {
        $content = (string) file_get_contents($file['tmp_name']);
        if (strncmp($content, "\x00\x00\x01\x00", 4) === 0) {
            return $content;
        }

        $info = @getimagesize($file['tmp_name']);
        $mime = $info ? $info['mime'] : '';
        if ($mime === 'image/png') {
            $image = imagecreatefrompng($file['tmp_name']);
        } elseif ($mime === 'image/jpeg') {
            $image = imagecreatefromjpeg($file['tmp_name']);
        } else {
            throw HttpException::badRequest('ตราสัญลักษณ์ต้องเป็นไฟล์ .png, .jpg หรือ .ico เท่านั้น');
        }

        return self::toIco(self::squarePng($image));
    }

    public static function save($icoContent)
    {
        if (file_put_contents(self::PATH, $icoContent, LOCK_EX) === false) {
            throw new RuntimeException('Cannot write ' . self::PATH);
        }
    }

    public static function store(array $file)
    {
        self::save(self::prepare($file));
    }

    /** ย่อภาพให้พอดีกรอบสี่เหลี่ยมจัตุรัส พื้นหลังโปร่งใส แล้วคืนค่าเป็น PNG */
    private static function squarePng($image)
    {
        $width = imagesx($image);
        $height = imagesy($image);
        $scale = min(self::SIZE / $width, self::SIZE / $height, 1);
        $newWidth = max(1, (int) round($width * $scale));
        $newHeight = max(1, (int) round($height * $scale));

        $canvas = imagecreatetruecolor(self::SIZE, self::SIZE);
        imagesavealpha($canvas, true);
        imagefill($canvas, 0, 0, imagecolorallocatealpha($canvas, 0, 0, 0, 127));
        imagecopyresampled(
            $canvas, $image,
            (int) ((self::SIZE - $newWidth) / 2), (int) ((self::SIZE - $newHeight) / 2), 0, 0,
            $newWidth, $newHeight, $width, $height
        );

        ob_start();
        imagepng($canvas);
        return ob_get_clean();
    }

    /** ห่อ PNG ด้วย header ของไฟล์ .ico (รองรับในเบราว์เซอร์ปัจจุบันทุกตัว) */
    public static function toIco($png)
    {
        $header = pack('vvv', 0, 1, 1);                                    // ICONDIR: 1 ภาพ
        $entry = pack('CCCCvvVV', 0, 0, 0, 0, 1, 32, strlen($png), 22);   // 0 = 256px, offset = 6 + 16
        return $header . $entry . $png;
    }
}
