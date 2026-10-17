<?php
require __DIR__ . '/../backend/bootstrap.php';
Auth::requireSuperAdmin();

View::page('admin/departments', [
    'page' => [
        'active'  => 'settings.departments',
        'modals'  => ['department-form'],
        'scripts' => ['pages/admin-departments.js'],
    ],
]);
