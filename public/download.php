<?php
require __DIR__ . '/../backend/bootstrap.php';

$project = Project::find((int) Request::int('id'));
if (!$project || (!Project::isPublished($project) && !Auth::check())) {
    Session::flash('error', 'ไม่พบโครงการ/กิจกรรม');
    redirect('index.php');
}

View::page('download', [
    'project' => $project,
    'page'    => [
        'back'    => 'index.php?p=' . max(1, (int) Request::int('p')),
        'scripts' => ['pages/download.js'],
        'data'    => ['projectId' => (int) $project['id']],
    ],
]);
