<?php
/**
 * ส่วนบนของหน้าเว็บ (ใช้คู่กับ frontend/layouts/end.php)
 *
 * @var array $page ดู frontend/layouts/sidebar.php และ frontend/layouts/end.php
 */
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <?php require __DIR__ . '/head.php'; ?>
</head>
<body>
<div class="wrapper">
    <?php require __DIR__ . '/navbar.php'; ?>
    <?php require __DIR__ . '/sidebar.php'; ?>

    <div class="main-panel">
        <div class="content">
            <div class="panel-header bg-primary-gradient">
                <div class="page-inner py-5 text-center">
                    <img class="d-inline mb-3" src="<?= e(Logo::url()) ?>" width="100" height="100" alt="">
                    <h2 class="d-block text-white mb-1 fw-bold">ระบบพิมพ์เกียรติบัตรออนไลน์</h2>
                    <h5 class="d-inline text-white op-7 mb-2"><?= e(School::name()) ?></h5>
                </div>
            </div>
            <div class="page-inner mt--5">
