<?php
require __DIR__ . '/../backend/bootstrap.php';
Auth::requireLogin();

$stats = [
    ['id' => 'stat-projects', 'icon' => 'flaticon-settings', 'label' => 'โครงการ'],
    ['id' => 'stat-participants', 'icon' => 'flaticon-users', 'label' => 'เกียรติบัตร'],
    ['id' => 'stat-admins', 'icon' => 'flaticon-success', 'label' => 'ผู้ดูแลระบบ'],
];

View::page('admin/projects', [
    'page'  => [
        'active'  => 'projects',
        'modals'  => ['project-form'],
        'scripts' => ['pages/admin-projects.js'],
        'data'    => ['defaultDepartmentId' => (int) Auth::user()['iddp']],
    ],
    'stats' => $stats,
]);
