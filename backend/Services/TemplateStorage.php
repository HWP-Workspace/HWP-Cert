<?php

/**
 * จัดเก็บไฟล์แม่แบบเกียรติบัตร (storage/uploads/templates) และภาพตัวอย่างย่อขนาด (storage/uploads/previews)
 * อยู่นอก public/ จึงเข้าถึงตรงจากเว็บไม่ได้ — ต้องอ่านผ่าน PHP เท่านั้น
 */
final class TemplateStorage
{
    const MAX_BYTES = 2097152; // 2 MB
    const MIME_EXTENSIONS = ['image/jpeg' => 'jpg', 'image/png' => 'png'];
    const PREVIEW_WIDTH = 400;
    const PREVIEW_HEIGHT = 283;

    /**
     * ตรวจสอบและบันทึกไฟล์แม่แบบของโครงการ พร้อมสร้างภาพตัวอย่าง
     */
    public static function store(array $project, array $file)
    {
        $info = @getimagesize($file['tmp_name']);
        $mime = $info ? $info['mime'] : '';
        if (!isset(self::MIME_EXTENSIONS[$mime])) {
            throw HttpException::badRequest('กรุณาอัปโหลดไฟล์รูปภาพ .jpg, .jpeg หรือ .png เท่านั้น');
        }

        $template = 'cert_pj-' . (int) $project['id'] . '.' . self::MIME_EXTENSIONS[$mime];
        $preview = 'preview_' . $template;

        if (!move_uploaded_file($file['tmp_name'], self::templatePath($template))) {
            throw new RuntimeException('Cannot move uploaded template');
        }
        self::createPreview(self::templatePath($template), $mime, self::previewPath($preview));

        // ไฟล์เดิมคนละนามสกุล (เช่น .png → .jpg) ต้องลบทิ้ง
        if ($project['tempate'] !== '' && $project['tempate'] !== $template) {
            self::delete($project['tempate'], $project['preview']);
        }

        Project::updateTemplate($project['id'], $template, $preview);
    }

    public static function delete($template, $preview)
    {
        foreach ([self::templatePath($template), self::previewPath($preview)] as $path) {
            if ($path !== null && is_file($path)) {
                unlink($path);
            }
        }
    }

    public static function templatePath($filename)
    {
        return self::path('/uploads/templates/', $filename);
    }

    public static function previewPath($filename)
    {
        return self::path('/uploads/previews/', $filename);
    }

    /** ภาพตัวอย่างแบบ data URI สำหรับฝังในหน้าเว็บ */
    public static function previewDataUri($preview)
    {
        $path = self::previewPath($preview);
        if ($path === null || !is_file($path)) {
            return null;
        }
        $info = getimagesize($path);
        return 'data:' . $info['mime'] . ';base64,' . base64_encode(file_get_contents($path));
    }

    /** ส่งไฟล์แม่แบบออกไปยังเบราว์เซอร์ */
    public static function output($template)
    {
        $path = self::templatePath($template);
        if ($path === null || !is_file($path)) {
            throw HttpException::notFound('ไม่พบไฟล์แม่แบบ');
        }
        header('Content-Type: ' . getimagesize($path)['mime']);
        header('Content-Length: ' . filesize($path));
        header('Cache-Control: private, no-cache');
        readfile($path);
        exit;
    }

    /** ใช้เฉพาะชื่อไฟล์ ป้องกัน path traversal */
    private static function path($directory, $filename)
    {
        $filename = basename((string) $filename);
        return $filename === '' ? null : STORAGE_PATH . $directory . $filename;
    }

    private static function createPreview($source, $mime, $destination)
    {
        $image = $mime === 'image/png' ? imagecreatefrompng($source) : imagecreatefromjpeg($source);
        $preview = imagecreatetruecolor(self::PREVIEW_WIDTH, self::PREVIEW_HEIGHT);
        imagecopyresampled($preview, $image, 0, 0, 0, 0, self::PREVIEW_WIDTH, self::PREVIEW_HEIGHT, imagesx($image), imagesy($image));

        if ($mime === 'image/png') {
            imagepng($preview, $destination);
        } else {
            imagejpeg($preview, $destination, 90);
        }
    }
}
