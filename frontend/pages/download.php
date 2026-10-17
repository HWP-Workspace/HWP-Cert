<?php
/**
 * รายชื่อผู้ได้รับเกียรติบัตรของโครงการ (สำหรับบุคคลทั่วไป)
 *
 * @var array $project
 */
require FRONTEND_PATH . '/layouts/start.php';
?>

<div class="card">
    <h3 class="card-header"><b><?= e($project['name']) ?></b></h3>
    <div class="card-body">
        <table id="participants" class="table nowrap" style="width: 100%">
            <thead class="table-light">
                <tr>
                    <th>ลำดับที่</th>
                    <th>ชื่อ-นามสกุล</th>
                    <th>เลขที่เกียรติบัตร</th>
                    <th>ดาวน์โหลด</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<?php require FRONTEND_PATH . '/layouts/end.php'; ?>
