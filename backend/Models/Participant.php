<?php

/**
 * ตาราง user — ผู้เข้าร่วมโครงการ/ผู้ได้รับเกียรติบัตร
 */
final class Participant
{
    public static function find($id)
    {
        return Database::fetch('SELECT id, idpj, name, line2, line3, idcer FROM user WHERE id = ?', [$id]);
    }

    public static function findInProject($id, $projectId)
    {
        return Database::fetch(
            'SELECT id, idpj, name, line2, line3, idcer FROM user WHERE id = ? AND idpj = ?',
            [$id, $projectId]
        );
    }

    public static function count()
    {
        return (int) Database::value('SELECT COUNT(*) FROM user');
    }

    public static function countInProject($projectId)
    {
        return (int) Database::value('SELECT COUNT(*) FROM user WHERE idpj = ?', [$projectId]);
    }

    /** เพิ่มผู้เข้าร่วมพร้อมออกเลขที่เกียรติบัตร */
    public static function create(array $project, $name, $line2 = '', $line3 = '')
    {
        list($line2, $line3) = self::linesForProject($project, $line2, $line3);

        return Database::insert(
            'INSERT INTO user (idpj, name, line2, line3, idcer) VALUES (?, ?, ?, ?, ?)',
            [$project['id'], $name, $line2, $line3, CertificateNumber::next($project['id'])]
        );
    }

    public static function update(array $project, $id, $name, $line2 = '', $line3 = '')
    {
        list($line2, $line3) = self::linesForProject($project, $line2, $line3);

        Database::execute(
            'UPDATE user SET name = ?, line2 = ?, line3 = ? WHERE id = ? AND idpj = ?',
            [$name, $line2, $line3, $id, $project['id']]
        );
    }

    public static function delete($id)
    {
        Database::execute('DELETE FROM user WHERE id = ?', [$id]);
    }

    public static function deleteAllInProject($projectId)
    {
        return Database::execute('DELETE FROM user WHERE idpj = ?', [$projectId]);
    }

    /** เก็บเฉพาะบรรทัดที่รูปแบบโครงการรองรับ */
    private static function linesForProject(array $project, $line2, $line3)
    {
        $extraLines = Project::extraLines($project);
        return [
            $extraLines >= 1 ? $line2 : '',
            $extraLines >= 2 ? $line3 : '',
        ];
    }
}
