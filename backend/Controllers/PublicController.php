<?php

/**
 * API สำหรับผู้ใช้ทั่วไป (ไม่ต้องล็อกอิน) — แสดงเฉพาะโครงการที่เผยแพร่แล้ว
 */
final class PublicController
{
    public static function routes()
    {
        return [
            'participants' => ['GET', [self::class, 'participants']],
        ];
    }

    public static function participants()
    {
        $project = Project::find(Request::requiredId('project'));
        if (!$project || (!Project::isPublished($project) && !Auth::check())) {
            throw HttpException::notFound('ไม่พบโครงการ/กิจกรรม');
        }

        DataTable::respond([
            'select' => 'id, name, idcer',
            'from'   => 'user',
            'where'  => 'idpj = ?',
            'params' => [$project['id']],
            'search' => ['name', 'idcer'],
            'order'  => [0 => 'id', 1 => 'name', 2 => 'idcer'],
            'row'    => function (array $row) use ($project) {
                $printUrl = 'print.php?id=' . (int) $project['id'] . '&learn=' . (int) $row['id'];
                return [
                    $row['id'],
                    e($row['name']),
                    e($row['idcer']),
                    '<a class="btn btn-sm btn-success" href="' . $printUrl . '" target="_blank" rel="noopener">'
                    . '<i class="far fa-arrow-alt-circle-down mr-1"></i> ดาวน์โหลด</a>',
                ];
            },
        ]);
    }
}
