<?php

final class ProjectController
{
    public static function routes()
    {
        return [
            'list'           => ['GET', [self::class, 'list']],
            'get'            => ['GET', [self::class, 'get']],
            'create'         => ['POST', [self::class, 'create']],
            'update'         => ['POST', [self::class, 'update']],
            'delete'         => ['POST', [self::class, 'delete']],
            'style'          => ['POST', [self::class, 'style']],
            'template'       => ['POST', [self::class, 'uploadTemplate']],
            'template_image' => ['GET', [self::class, 'templateImage']],
        ];
    }

    public static function list()
    {
        Auth::authorize();

        $options = [
            'select' => 'p.id, p.name, p.tempate, p.date, d.name AS dp_name',
            'from'   => 'project p LEFT JOIN dp d ON d.id = p.iddp',
            'search' => ['p.name', 'd.name'],
            'order'  => [0 => 'p.id', 1 => 'p.tempate', 2 => 'p.name', 3 => 'd.name', 4 => 'p.date'],
            'row'    => function (array $row) {
                $status = $row['tempate'] !== ''
                    ? '<i class="fas fa-check-circle fa-2x text-success align-middle mr-2"></i> เผยแพร่'
                    : '<i class="fas fa-exclamation-circle fa-2x text-warning align-middle mr-2"></i> แม่แบบ';

                return [
                    $row['id'],
                    $status,
                    e($row['name']),
                    e($row['dp_name']),
                    thai_date($row['date']),
                    '<a class="btn btn-sm btn-primary mr-1" href="admin_pj.php?id=' . (int) $row['id'] . '" title="ตั้งค่า"><i class="fas fa-wrench"></i></a>'
                    . action_button('edit', $row['id'], 'warning', 'far fa-edit', 'แก้ไข')
                    . action_button('delete', $row['id'], 'danger', 'fas fa-trash', 'ลบ'),
                ];
            },
        ];

        if (!Auth::canSeeAllProjects()) {
            $options['where'] = 'p.iddp = ?';
            $options['params'] = [Auth::user()['iddp']];
        }

        DataTable::respond($options);
    }

    public static function get()
    {
        $project = Auth::authorizeProject(Request::requiredId());
        Response::json([
            'ok'   => true,
            'data' => [
                'id'   => (int) $project['id'],
                'name' => $project['name'],
                'date' => $project['date'],
                'type' => (int) $project['type'],
                'iddp' => (int) $project['iddp'],
            ],
        ]);
    }

    public static function create()
    {
        Auth::authorize();
        $input = self::input(Auth::user()['iddp']);
        Project::create($input['name'], $input['iddp'], $input['date'], $input['type']);
        Response::success('บันทึกโครงการ/กิจกรรมสำเร็จ');
    }

    public static function update()
    {
        $project = Auth::authorizeProject(Request::requiredId());
        $input = self::input($project['iddp']);
        Project::update($project['id'], $input['name'], $input['iddp'], $input['date'], $input['type']);
        Response::success('แก้ไขโครงการ/กิจกรรมสำเร็จ');
    }

    public static function delete()
    {
        Project::delete(Auth::authorizeProject(Request::requiredId()));
        Response::success('ลบโครงการ/กิจกรรมสำเร็จ');
    }

    public static function style()
    {
        $project = Auth::authorizeProject(Request::requiredId());
        $extraLines = Project::extraLines($project);

        $color = Request::string('color', 7);
        if (!preg_match('/^#[0-9a-fA-F]{6}$/', $color)) {
            throw HttpException::badRequest('รูปแบบสีฟอนต์ไม่ถูกต้อง');
        }

        Project::updateStyle($project['id'], [
            'font'       => Request::oneOf('font', 'ฟอนต์', array_keys(Project::FONTS)),
            'margin'     => Request::intInRange('margin', 'ระยะขอบ', 0, 1000),
            'color'      => $color,
            'size_name'  => Request::intInRange('size_name', 'ขนาดฟอนต์บรรทัดที่ 1', 0, 144),
            'size_line2' => $extraLines >= 1 ? Request::intInRange('size_line2', 'ขนาดฟอนต์บรรทัดที่ 2', 0, 144) : $project['size_line2'],
            'size_line3' => $extraLines >= 2 ? Request::intInRange('size_line3', 'ขนาดฟอนต์บรรทัดที่ 3', 0, 144) : $project['size_line3'],
        ]);
        Response::success('แก้ไขรูปแบบเกียรติบัตรสำเร็จ');
    }

    public static function uploadTemplate()
    {
        $project = Auth::authorizeProject(Request::requiredId());
        $file = Request::file('template', TemplateStorage::MAX_BYTES);
        if ($file === null) {
            throw HttpException::badRequest('กรุณาเลือกไฟล์แม่แบบ');
        }
        TemplateStorage::store($project, $file);
        Response::success('อัปโหลดแม่แบบเกียรติบัตรสำเร็จ');
    }

    public static function templateImage()
    {
        TemplateStorage::output(Auth::authorizeProject(Request::requiredId())['tempate']);
    }

    /** ข้อมูลโครงการจากฟอร์ม — เฉพาะผู้ดูแลระบบสูงสุดที่เลือกกลุ่ม/งานได้ */
    private static function input($defaultDepartmentId)
    {
        $departmentId = $defaultDepartmentId;
        if (Auth::isSuperAdmin()) {
            $departmentId = Request::requiredId('iddp');
            if (!Department::exists($departmentId)) {
                throw HttpException::badRequest('กรุณาเลือกกลุ่ม/งาน');
            }
        }

        return [
            'name' => Request::requiredString('name', 'ชื่อโครงการ/กิจกรรม'),
            'date' => Request::date('date', 'วันที่'),
            'type' => (int) Request::oneOf('type', 'รูปแบบ', array_keys(Project::TYPES)),
            'iddp' => $departmentId,
        ];
    }
}
