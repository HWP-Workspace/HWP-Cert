<?php

/**
 * ตาราง project — โครงการ/กิจกรรม
 * (ชื่อคอลัมน์ `tempate` สะกดตามฐานข้อมูลเดิมเพื่อให้อัปเดตได้โดยไม่ต้อง migrate)
 */
final class Project
{
    const TYPE_NAME_ONLY = 0;
    const TYPE_ONE_EXTRA_LINE = 1;
    const TYPE_TWO_EXTRA_LINES = 2;

    const TYPES = [
        self::TYPE_NAME_ONLY       => 'ชื่อ-นามสกุล เท่านั้น',
        self::TYPE_ONE_EXTRA_LINE  => 'ชื่อ-นามสกุล และเพิ่มอีก 1 บรรทัด',
        self::TYPE_TWO_EXTRA_LINES => 'ชื่อ-นามสกุล และเพิ่มอีก 2 บรรทัด',
    ];

    const FONTS = [
        'thsarabunnew' => 'TH Sarabun New (ค่าเริ่มต้น)',
        'thniramitas'  => 'TH Niramit AS',
    ];

    const DEFAULT_FONT = 'thsarabunnew';
    const DEFAULT_SIZE_NAME = 48;
    const DEFAULT_SIZE_LINE = 36;
    const DEFAULT_MARGIN = 210;
    const DEFAULT_COLOR = '#000000';

    public static function find($id)
    {
        return Database::fetch(
            'SELECT p.*, d.name AS dp_name, d.shortdp
             FROM project p LEFT JOIN dp d ON d.id = p.iddp
             WHERE p.id = ?',
            [$id]
        );
    }

    public static function count()
    {
        return (int) Database::value('SELECT COUNT(*) FROM project');
    }

    public static function isPublished(array $project)
    {
        return $project['tempate'] !== '';
    }

    /** จำนวนบรรทัดเพิ่มเติม (นอกจากชื่อ) ตามรูปแบบโครงการ */
    public static function extraLines(array $project)
    {
        return (int) $project['type'];
    }

    public static function create($name, $departmentId, $date, $type)
    {
        return Database::insert(
            'INSERT INTO project (name, iddp, date, tempate, preview, font, size_name, size_line2, size_line3, margin, color, type)
             VALUES (?, ?, ?, \'\', \'\', ?, ?, ?, ?, ?, ?, ?)',
            [
                $name, $departmentId, $date,
                self::DEFAULT_FONT, self::DEFAULT_SIZE_NAME, self::DEFAULT_SIZE_LINE, self::DEFAULT_SIZE_LINE,
                self::DEFAULT_MARGIN, self::DEFAULT_COLOR, $type,
            ]
        );
    }

    /**
     * แก้ไขข้อมูลโครงการ — หากลดจำนวนบรรทัดลง จะรีเซ็ตขนาดฟอนต์และล้างข้อมูลบรรทัดที่ไม่ใช้ของผู้เข้าร่วม
     */
    public static function update($id, $name, $departmentId, $date, $type)
    {
        Database::transaction(function () use ($id, $name, $departmentId, $date, $type) {
            Database::execute(
                'UPDATE project SET name = ?, iddp = ?, date = ?, type = ? WHERE id = ?',
                [$name, $departmentId, $date, $type, $id]
            );

            if ($type < self::TYPE_TWO_EXTRA_LINES) {
                Database::execute('UPDATE project SET size_line3 = ? WHERE id = ?', [self::DEFAULT_SIZE_LINE, $id]);
                Database::execute("UPDATE user SET line3 = '' WHERE idpj = ?", [$id]);
            }
            if ($type < self::TYPE_ONE_EXTRA_LINE) {
                Database::execute('UPDATE project SET size_line2 = ? WHERE id = ?', [self::DEFAULT_SIZE_LINE, $id]);
                Database::execute("UPDATE user SET line2 = '' WHERE idpj = ?", [$id]);
            }
        });
    }

    public static function updateStyle($id, array $style)
    {
        Database::execute(
            'UPDATE project SET font = ?, margin = ?, color = ?, size_name = ?, size_line2 = ?, size_line3 = ? WHERE id = ?',
            [$style['font'], $style['margin'], $style['color'], $style['size_name'], $style['size_line2'], $style['size_line3'], $id]
        );
    }

    public static function updateTemplate($id, $template, $preview)
    {
        Database::execute('UPDATE project SET tempate = ?, preview = ? WHERE id = ?', [$template, $preview, $id]);
    }

    /** ลบโครงการ พร้อมผู้เข้าร่วมและไฟล์เทมเพลต */
    public static function delete(array $project)
    {
        Database::transaction(function () use ($project) {
            Database::execute('DELETE FROM user WHERE idpj = ?', [$project['id']]);
            Database::execute('DELETE FROM project WHERE id = ?', [$project['id']]);
        });
        TemplateStorage::delete($project['tempate'], $project['preview']);
    }
}
