<?php
/**
 * พิมพ์เกียรติบัตร PDF — print.php?id={รหัสโครงการ}&learn={รหัสผู้เข้าร่วม}
 * URL นี้ถูกฝังเป็น QR code ในเกียรติบัตร ห้ามเปลี่ยนชื่อไฟล์/พารามิเตอร์
 */
require __DIR__ . '/../backend/bootstrap.php';

$project = Project::find((int) Request::int('id'));
$participant = $project ? Participant::findInProject((int) Request::int('learn'), $project['id']) : null;

if (!$participant) {
    Session::flash('error', 'ไม่พบเกียรติบัตรของท่าน');
    redirect('index.php');
}

if (!Project::isPublished($project)) {
    if (Auth::check()) {
        Session::flash('warning', 'กรุณาอัปโหลดแม่แบบเกียรติบัตรก่อนพิมพ์');
        redirect('admin_pj.php?id=' . (int) $project['id']);
    }
    Session::flash('error', 'เกียรติบัตรยังไม่เผยแพร่');
    redirect('index.php');
}

CertificatePdf::output($project, $participant, current_url());
