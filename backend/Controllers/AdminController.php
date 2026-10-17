<?php

/** จัดการผู้ดูแลระบบ — เฉพาะผู้ดูแลระบบสูงสุด */
final class AdminController
{
    const PASSWORD_MIN_LENGTH = 8;

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
            'select' => 'a.id, a.name, a.username, d.name AS dp_name, d.shortdp',
            'from'   => 'admin a LEFT JOIN dp d ON d.id = a.iddp',
            'search' => ['a.name', 'a.username', 'd.name', 'd.shortdp'],
            'order'  => [0 => 'a.id', 1 => 'a.name', 2 => 'a.username', 3 => 'd.name', 4 => 'd.shortdp'],
            'row'    => function (array $row) {
                return [
                    $row['id'],
                    e($row['name']),
                    e($row['username']),
                    e($row['dp_name']),
                    e($row['shortdp']),
                    action_button('edit', $row['id'], 'warning', 'far fa-edit', 'แก้ไข')
                    . action_button('delete', $row['id'], 'danger', 'fas fa-trash', 'ลบ', self::isDeletable($row)),
                ];
            },
        ]);
    }

    public static function get()
    {
        Auth::authorizeSuperAdmin();
        $admin = self::findOrFail(Request::requiredId());
        Response::json(['ok' => true, 'data' => [
            'id'       => (int) $admin['id'],
            'username' => $admin['username'],
            'name'     => $admin['name'],
            'iddp'     => (int) $admin['iddp'],
        ]]);
    }

    public static function create()
    {
        Auth::authorizeSuperAdmin();

        $username = Request::string('username', 20);
        if (!preg_match('/^[A-Za-z0-9_.-]{5,20}$/', $username)) {
            throw HttpException::badRequest('ชื่อผู้ใช้ต้องเป็นภาษาอังกฤษ ตัวเลข หรือ _ . - ความยาว 5-20 ตัวอักษร');
        }
        if (Admin::usernameExists($username)) {
            throw HttpException::badRequest('ชื่อผู้ใช้งานซ้ำกันในระบบ');
        }

        $password = self::passwordInput('password');
        if (!hash_equals($password, Request::string('password_confirmation', 72))) {
            throw HttpException::badRequest('รหัสผ่านไม่ตรงกัน');
        }

        Admin::create($username, $password, Request::requiredString('name', 'ชื่อผู้ดูแล', 100), self::departmentInput());
        Response::success('เพิ่มผู้ดูแลระบบสำเร็จ');
    }

    public static function update()
    {
        Auth::authorizeSuperAdmin();
        $admin = self::findOrFail(Request::requiredId());

        Admin::update($admin['id'], Request::requiredString('name', 'ชื่อผู้ดูแล', 100), self::departmentInput());
        if (Request::string('password', 72) !== '') {
            Admin::updatePassword($admin['id'], self::passwordInput('password'));
        }
        Response::success('แก้ไขผู้ดูแลระบบสำเร็จ');
    }

    public static function delete()
    {
        Auth::authorizeSuperAdmin();
        $admin = self::findOrFail(Request::requiredId());
        if (!self::isDeletable($admin)) {
            throw HttpException::forbidden('ไม่สามารถลบบัญชีนี้ได้');
        }
        Admin::delete($admin['id']);
        Response::success('ลบผู้ดูแลระบบสำเร็จ');
    }

    /** ห้ามลบผู้ดูแลระบบสูงสุด และห้ามลบบัญชีตัวเอง */
    private static function isDeletable(array $admin)
    {
        return $admin['username'] !== Auth::SUPER_ADMIN_USERNAME && (int) $admin['id'] !== Auth::id();
    }

    private static function findOrFail($id)
    {
        $admin = Admin::find($id);
        if (!$admin) {
            throw HttpException::notFound('ไม่พบผู้ดูแลระบบ');
        }
        return $admin;
    }

    private static function departmentInput()
    {
        $departmentId = Request::requiredId('iddp');
        if (!Department::exists($departmentId)) {
            throw HttpException::badRequest('กรุณาเลือกกลุ่ม/งาน');
        }
        return $departmentId;
    }

    private static function passwordInput($key)
    {
        $password = Request::string($key, 72);
        if (mb_strlen($password) < self::PASSWORD_MIN_LENGTH) {
            throw HttpException::badRequest('รหัสผ่านต้องมีอย่างน้อย ' . self::PASSWORD_MIN_LENGTH . ' ตัวอักษร');
        }
        return $password;
    }
}
