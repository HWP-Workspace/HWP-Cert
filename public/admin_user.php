<?php
require __DIR__ . '/../backend/bootstrap.php';
Auth::requireSuperAdmin();

View::page('admin/admins', [
    'page' => [
        'active'  => 'settings.admins',
        'modals'  => ['admin-form'],
        'scripts' => ['pages/admin-users.js'],
    ],
]);
