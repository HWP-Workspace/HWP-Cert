<?php

/**
 * ออกเลขที่เกียรติบัตร รูปแบบ: {ชื่อย่อโรงเรียน}.{ชื่อย่อกลุ่ม/งาน}.{ปี พ.ศ.}.{รหัสโครงการ}/{ลำดับ}
 * เช่น ตว.งคพ.2568.12/7
 */
final class CertificateNumber
{
    public static function next($projectId)
    {
        $project = Database::fetch(
            'SELECT p.id, p.date, d.shortdp FROM project p LEFT JOIN dp d ON d.id = p.iddp WHERE p.id = ?',
            [$projectId]
        );

        $prefix = sprintf(
            '%s.%s.%d.%d/',
            School::get()['shortname'],
            $project['shortdp'],
            thai_year($project['date']),
            $project['id']
        );

        // ลำดับถัดไป — ถ้าซ้ำ (เช่นเคยลบผู้เข้าร่วมกลางรายการ) ให้ขยับไปจนกว่าจะว่าง
        $sequence = Participant::countInProject($projectId) + 1;
        while (self::exists($prefix . $sequence)) {
            $sequence++;
        }
        return $prefix . $sequence;
    }

    private static function exists($number)
    {
        return Database::value('SELECT 1 FROM user WHERE idcer = ? LIMIT 1', [$number]) !== null;
    }
}
