<?php
/**
 * จัดการโครงการ/กิจกรรม
 *
 * @var array $stats
 */
require FRONTEND_PATH . '/layouts/start.php';
?>

<div class="row">
    <?php foreach ($stats as $stat): ?>
        <div class="col-md-4 d-none d-xl-block">
            <div class="card card-stats card-primary card-round">
                <div class="card-body">
                    <div class="row">
                        <div class="col-5">
                            <div class="icon-big text-center"><i class="<?= $stat['icon'] ?>"></i></div>
                        </div>
                        <div class="col-7 col-stats">
                            <div class="numbers">
                                <p class="card-category"><?= $stat['label'] ?></p>
                                <h4 class="card-title" id="<?= $stat['id'] ?>">-</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<div class="card">
    <h2 class="card-header">
        <b>ตั้งค่าโครงการ/กิจกรรม</b>
        <div class="float-right">
            <button type="button" class="btn btn-sm btn-primary" id="add-project"><i class="fas fa-plus mr-1"></i> เพิ่ม</button>
        </div>
    </h2>
    <div class="card-body">
        <table id="projects" class="table nowrap" style="width: 100%">
            <thead class="table-light">
                <tr>
                    <th>ลำดับที่</th>
                    <th>สถานะ</th>
                    <th>โครงการ</th>
                    <th>กลุ่ม/งาน</th>
                    <th>วันที่</th>
                    <th>ดำเนินการ</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<?php require FRONTEND_PATH . '/layouts/end.php'; ?>
