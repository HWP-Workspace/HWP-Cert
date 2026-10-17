<?php
require __DIR__ . '/../backend/bootstrap.php';
Auth::requireSuperAdmin();

$school = School::get();

View::page('admin/settings', [
    'page'   => ['active' => 'settings.general'],
    'school' => $school,
]);
