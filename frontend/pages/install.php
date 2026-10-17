<?php
/**
 * หน้าติดตั้ง/อัปเดตระบบ (ไม่ใช้ layout หลัก เพราะยังไม่มีฐานข้อมูล)
 *
 * @var string $pageTitle
 * @var array  $state        ดู Installer::state()
 * @var array  $requirements ดู Installer::requirements()
 * @var array  $database     ค่าฐานข้อมูลปัจจุบัน/ค่าเริ่มต้น
 */
$ready = !in_array(false, array_column($requirements, 'ok'), true);
$isUpgrade = !$state['canEditDatabase'];
$page = ['scripts' => ['pages/install.js']];
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <?php require FRONTEND_PATH . '/layouts/head.php'; ?>
</head>
<body class="bg-light">
<div class="container py-5" style="max-width: 760px;">
    <div class="text-center mb-4">
        <img src="<?= e(Logo::url()) ?>" width="80" height="80" alt="">
        <h2 class="mt-3 mb-1 fw-bold">ติดตั้งระบบพิมพ์เกียรติบัตรออนไลน์</h2>
        <p class="op-7">เวอร์ชัน <?= e(Config::get('app.version')) ?></p>
    </div>

    <div class="card">
        <h4 class="card-header"><b>1. ตรวจสอบความพร้อมของเซิร์ฟเวอร์</b></h4>
        <div class="card-body">
            <ul class="list-unstyled mb-0">
                <?php foreach ($requirements as $requirement): ?>
                    <li class="mb-1">
                        <i class="fas <?= $requirement['ok'] ? 'fa-check-circle text-success' : 'fa-times-circle text-danger' ?> mr-2"></i>
                        <?= e($requirement['label']) ?>
                    </li>
                <?php endforeach; ?>
            </ul>
            <?php if (!$ready): ?>
                <div class="alert alert-danger mt-3 mb-0">กรุณาแก้ไขรายการที่ไม่ผ่าน (เช่น ให้สิทธิ์เขียนไฟล์) แล้วรีเฟรชหน้านี้</div>
            <?php endif; ?>
        </div>
    </div>

    <form action="api/install.php?action=install" method="post" data-ajax data-success="redirect" autocomplete="off">
        <?= Csrf::field() ?>

        <?php if ($state['error']): ?>
            <div class="alert alert-warning"><?= e($state['error']) ?></div>
        <?php endif; ?>

        <?php if ($isUpgrade): ?>
            <div class="card">
                <h4 class="card-header"><b>2. อัปเดตฐานข้อมูล</b></h4>
                <div class="card-body">
                    พบการตั้งค่าเดิมและผู้ดูแลระบบในฐานข้อมูลแล้ว ระบบจะอัปเดตโครงสร้างฐานข้อมูลเป็นเวอร์ชันล่าสุด <b>โดยไม่ลบข้อมูลเดิม</b>
                </div>
            </div>
        <?php endif; ?>

        <?php if ($state['canEditDatabase']): ?>
            <div class="card">
                <h4 class="card-header"><b>2. ฐานข้อมูล MySQL / MariaDB</b></h4>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label for="db-host">Host</label>
                            <input type="text" class="form-control" id="db-host" name="db_host" value="<?= e($database['host']) ?>" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="db-port">Port</label>
                            <input type="number" class="form-control" id="db-port" name="db_port" value="<?= (int) $database['port'] ?>" min="1" max="65535" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="db-name">ชื่อฐานข้อมูล</label>
                            <input type="text" class="form-control" id="db-name" name="db_name" value="<?= e($database['name']) ?>" pattern="[A-Za-z0-9_\-]+" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="db-user">ชื่อผู้ใช้</label>
                            <input type="text" class="form-control" id="db-user" name="db_user" value="<?= e($database['user']) ?>" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="db-pass">รหัสผ่าน</label>
                            <input type="password" class="form-control" id="db-pass" name="db_pass" autocomplete="new-password">
                        </div>
                    </div>
                    <small class="form-text text-muted">หากยังไม่มีฐานข้อมูลนี้ ระบบจะสร้างให้อัตโนมัติ (ผู้ใช้ต้องมีสิทธิ์สร้างฐานข้อมูล) — ถ้าเป็นฐานข้อมูลของเวอร์ชันเดิม ข้อมูลจะยังอยู่ครบ</small>
                    <div class="text-center mt-3">
                        <button type="button" class="btn btn-info" id="check-database"<?= $ready ? '' : ' disabled' ?>><i class="fas fa-plug mr-1"></i> ตรวจสอบการเชื่อมต่อ</button>
                    </div>
                    <div class="alert alert-success mt-3 mb-0" id="database-new" style="display: none;">เชื่อมต่อสำเร็จ — ฐานข้อมูลใหม่ กรุณากรอกข้อมูลหน่วยงานและผู้ดูแลระบบด้านล่าง</div>
                    <div class="alert alert-info mt-3 mb-0" id="database-existing" style="display: none;">เชื่อมต่อสำเร็จ — พบข้อมูลเดิมในฐานข้อมูลนี้ ระบบจะอัปเดตโครงสร้างโดย<b>ไม่ลบหรือแก้ไขข้อมูลเดิม</b> (ใช้ชื่อผู้ใช้/รหัสผ่านเดิมเข้าสู่ระบบ)</div>
                </div>
            </div>

            <div id="setup-section" style="display: none;">
                <div class="card">
                    <h4 class="card-header"><b>3. ข้อมูลหน่วยงาน</b></h4>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label for="school-name">ชื่อหน่วยงาน/โรงเรียน</label>
                                <input type="text" class="form-control" id="school-name" name="school_name" maxlength="255" placeholder="เช่น โรงเรียนตัวอย่างวิทยา" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="school-shortname">ชื่อย่อ</label>
                                <input type="text" class="form-control" id="school-shortname" name="school_shortname" maxlength="10" placeholder="เช่น ตว" required>
                            </div>
                            <div class="col-md-8 mb-3">
                                <label for="department-name">กลุ่ม/งานหลัก (เห็นและจัดการได้ทุกโครงการ)</label>
                                <input type="text" class="form-control" id="department-name" name="department_name" maxlength="255" placeholder="เช่น งานคอมพิวเตอร์" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="department-shortname">ชื่อย่อกลุ่ม/งาน</label>
                                <input type="text" class="form-control" id="department-shortname" name="department_shortname" maxlength="50" placeholder="เช่น งคพ" required>
                            </div>
                        </div>
                        <small class="form-text text-muted">ชื่อย่อทั้งสองใช้รันเลขที่เกียรติบัตร เช่น ตว.งคพ.2568.1/1</small>

                        <label class="mt-3" for="school-logo">ตราสัญลักษณ์ (ไม่บังคับ — .png, .jpg หรือ .ico ไม่เกิน 2 MB เปลี่ยนภายหลังได้ในหน้าตั้งค่า)</label>
                        <div class="d-flex align-items-center">
                            <img id="logo-preview" src="<?= e(Logo::url()) ?>" width="64" height="64" class="mr-3" alt="">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="school-logo" name="logo" accept=".png,.jpg,.jpeg,.ico" data-max-bytes="<?= Logo::MAX_BYTES ?>">
                                <label class="custom-file-label" for="school-logo">เลือกไฟล์</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <h4 class="card-header"><b>4. ผู้ดูแลระบบสูงสุด</b></h4>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="admin-username">ชื่อผู้ใช้</label>
                                <input type="text" class="form-control" id="admin-username" value="<?= e(Auth::SUPER_ADMIN_USERNAME) ?>" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="admin-name">ชื่อผู้ดูแล</label>
                                <input type="text" class="form-control" id="admin-name" name="admin_name" maxlength="100" placeholder="ผู้ดูแลระบบ" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="admin-password">รหัสผ่าน</label>
                                <input type="password" class="form-control" id="admin-password" name="admin_password" minlength="8" maxlength="72" autocomplete="new-password" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="admin-password-confirmation">ยืนยันรหัสผ่าน</label>
                                <input type="password" class="form-control" id="admin-password-confirmation" name="admin_password_confirmation" minlength="8" maxlength="72" autocomplete="new-password" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <div class="text-center">
            <button type="submit" class="btn btn-primary btn-lg" id="install-submit"<?= $ready && $isUpgrade ? '' : ' disabled' ?>>
                <i class="fas fa-download mr-1"></i> <?= $isUpgrade ? 'อัปเดตฐานข้อมูล' : 'ติดตั้งระบบ' ?>
            </button>
        </div>
    </form>
</div>

<?php require FRONTEND_PATH . '/layouts/scripts.php'; ?>
</body>
</html>
