<?php

final class ParticipantController
{
    public static function routes()
    {
        return [
            'list'       => ['GET', [self::class, 'list']],
            'get'        => ['GET', [self::class, 'get']],
            'create'     => ['POST', [self::class, 'create']],
            'update'     => ['POST', [self::class, 'update']],
            'delete'     => ['POST', [self::class, 'delete']],
            'delete_all' => ['POST', [self::class, 'deleteAll']],
            'import'     => ['POST', [self::class, 'import']],
        ];
    }

    public static function list()
    {
        $project = Auth::authorizeProject(Request::requiredId('project'));

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
                    '<a class="btn btn-sm btn-primary mr-1" href="' . $printUrl . '" target="_blank" rel="noopener" title="พิมพ์"><i class="fas fa-print"></i></a>'
                    . action_button('edit', $row['id'], 'warning', 'far fa-edit', 'แก้ไข')
                    . action_button('delete', $row['id'], 'danger', 'fas fa-trash', 'ลบ'),
                ];
            },
        ]);
    }

    public static function get()
    {
        list(, $participant) = self::authorize(Request::requiredId());
        Response::json(['ok' => true, 'data' => $participant]);
    }

    public static function create()
    {
        $project = Auth::authorizeProject(Request::requiredId('project'));
        Participant::create(
            $project,
            Request::requiredString('name', 'ชื่อ-นามสกุล'),
            Request::string('line2'),
            Request::string('line3')
        );
        Response::success('เพิ่มผู้เข้าร่วมโครงการ/กิจกรรมสำเร็จ');
    }

    public static function update()
    {
        list($project, $participant) = self::authorize(Request::requiredId());
        Participant::update(
            $project,
            $participant['id'],
            Request::requiredString('name', 'ชื่อ-นามสกุล'),
            Request::string('line2'),
            Request::string('line3')
        );
        Response::success('แก้ไขข้อมูลผู้เข้าร่วมสำเร็จ');
    }

    public static function delete()
    {
        list(, $participant) = self::authorize(Request::requiredId());
        Participant::delete($participant['id']);
        Response::success('ลบข้อมูลผู้เข้าร่วมสำเร็จ');
    }

    public static function deleteAll()
    {
        $project = Auth::authorizeProject(Request::requiredId('project'));
        $deleted = Participant::deleteAllInProject($project['id']);
        if ($deleted === 0) {
            throw HttpException::badRequest('ไม่มีรายชื่อผู้เข้าร่วมในโครงการ/กิจกรรมนี้');
        }
        Response::success("ลบผู้เข้าร่วมทั้งหมด {$deleted} รายการสำเร็จ");
    }

    public static function import()
    {
        $project = Auth::authorizeProject(Request::requiredId('project'));
        $file = Request::file('file', ParticipantImporter::MAX_BYTES);
        if ($file === null) {
            throw HttpException::badRequest('กรุณาเลือกไฟล์ที่ต้องการนำเข้า');
        }

        $imported = ParticipantImporter::import($project, $file);
        if ($imported === 0) {
            throw HttpException::badRequest('ไม่พบรายชื่อในไฟล์ (แถวแรกของไฟล์คือหัวตาราง)');
        }
        Response::success("นำเข้าผู้เข้าร่วม {$imported} รายการสำเร็จ");
    }

    /** คืนค่าโครงการและผู้เข้าร่วม หากผู้ใช้มีสิทธิ์จัดการ */
    private static function authorize($id)
    {
        Auth::authorize();
        $participant = Participant::find($id);
        if (!$participant) {
            throw HttpException::notFound('ไม่พบผู้เข้าร่วม');
        }
        return [Auth::authorizeProject($participant['idpj']), $participant];
    }
}
