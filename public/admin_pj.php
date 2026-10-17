<?php
require __DIR__ . '/../backend/bootstrap.php';
Auth::requireLogin();

$project = Project::find((int) Request::int('id'));
if (!$project || !Auth::canManageProject($project)) {
    redirect('admin.php');
}

$projectId = (int) $project['id'];
$extraLines = Project::extraLines($project);
$fontSizes = [['size_name', 'ขนาดฟอนต์ (บรรทัดที่ 1)']];
if ($extraLines >= 1) {
    $fontSizes[] = ['size_line2', 'ขนาดฟอนต์ (บรรทัดที่ 2)'];
}
if ($extraLines >= 2) {
    $fontSizes[] = ['size_line3', 'ขนาดฟอนต์ (บรรทัดที่ 3)'];
}

View::page('admin/project', [
    'page'       => [
        'active'  => 'projects',
        'back'    => 'admin.php',
        'modals'  => ['participant-form', 'participant-import', 'template-upload'],
        'scripts' => ['pages/admin-project.js'],
        'data'    => ['projectId' => $projectId],
    ],
    'project'    => $project,
    'projectId'  => $projectId,
    'extraLines' => $extraLines,
    'fontSizes'  => $fontSizes,
]);
