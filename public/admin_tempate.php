<?php
require __DIR__ . '/../backend/bootstrap.php';
Auth::requireLogin();

$templates = [
    'name.psd'  => 'ชื่อ-นามสกุล เท่านั้น',
    'line2.psd' => 'ชื่อ-นามสกุล + 1 บรรทัด',
    'line3.psd' => 'ชื่อ-นามสกุล + 2 บรรทัด',
];

View::page('admin/templates', [
    'page'      => ['active' => 'templates'],
    'templates' => $templates,
]);
