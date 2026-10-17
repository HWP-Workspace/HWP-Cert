<?php

/** จัดการกลุ่ม/งาน — เฉพาะผู้ดูแลระบบสูงสุด */
final class DepartmentController
{
    public static function routes()
    {
        return [
            'list'   => ['GET', [self::class, 'list']],
            'get'    => ['GET', [self::class, 'get']],
            'create' => ['POST', [self::class, 'create']],
            'update' => ['POST', [self::class, 'update']],
            'delete' => ['POST', [self::class, 'delete']],
        ];
    }

    public static function list()
    {
        Auth::authorizeSuperAdmin();

        DataTable::respond([
            'select' => 'd.id, d.name, d.shortdp,
                         (SELECT COUNT(*) FROM admin a WHERE a.iddp = d.id) AS admin_count,
                         (SELECT COUNT(*) FROM project p WHERE p.iddp = d.id) AS project_count',
            'from'   => 'dp d',
            'search' => ['d.name', 'd.shortdp'],
            'order'  => [0 => 'd.id', 1 => 'd.name', 2 => 'd.shortdp', 3 => 'admin_count', 4 => 'project_count'],
            'row'    => function (array $row) {
                $deletable = Department::isDeletable($row['id'], $row['admin_count'], $row['project_count']);
                return [
                    $row['id'],
                    e($row['name']),
                    e($row['shortdp']),
                    (int) $row['admin_count'],
                    (int) $row['project_count'],
                    action_button('edit', $row['id'], 'warning', 'far fa-edit', 'แก้ไข')
                    . action_button('delete', $row['id'], 'danger', 'fas fa-trash', 'ลบ', $deletable),
                ];
            },
        ]);
    }

    public static function get()
    {
        Auth::authorizeSuperAdmin();
        Response::json(['ok' => true, 'data' => self::findOrFail(Request::requiredId())]);
    }

    public static function create()
    {
        Auth::authorizeSuperAdmin();
        list($name, $shortName) = self::input();
        Department::create($name, $shortName);
        Response::success('บันทึกกลุ่ม/งานสำเร็จ');
    }

    public static function update()
    {
        Auth::authorizeSuperAdmin();
        $department = self::findOrFail(Request::requiredId());
        list($name, $shortName) = self::input();
        Department::update($department['id'], $name, $shortName);
        Response::success('แก้ไขกลุ่ม/งานสำเร็จ');
    }

    public static function delete()
    {
        Auth::authorizeSuperAdmin();
        $department = self::findOrFail(Request::requiredId());

        $adminCount = Database::value('SELECT COUNT(*) FROM admin WHERE iddp = ?', [$department['id']]);
        $projectCount = Database::value('SELECT COUNT(*) FROM project WHERE iddp = ?', [$department['id']]);
        if (!Department::isDeletable($department['id'], $adminCount, $projectCount)) {
            throw HttpException::badRequest('ไม่สามารถลบได้ เนื่องจากยังมีผู้ดูแลระบบหรือโครงการอยู่ในกลุ่ม/งานนี้');
        }

        Department::delete($department['id']);
        Response::success('ลบกลุ่ม/งานสำเร็จ');
    }

    private static function input()
    {
        return [
            Request::requiredString('name', 'ชื่อกลุ่ม/งาน'),
            Request::requiredString('shortdp', 'ชื่อย่อกลุ่ม/งาน', 50),
        ];
    }

    private static function findOrFail($id)
    {
        $department = Department::find($id);
        if (!$department) {
            throw HttpException::notFound('ไม่พบกลุ่ม/งาน');
        }
        return $department;
    }
}
