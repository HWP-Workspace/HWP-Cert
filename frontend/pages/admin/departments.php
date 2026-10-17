<?php
/**
 * ตั้งค่ากลุ่ม/งาน
 */
require FRONTEND_PATH . '/layouts/start.php';
?>

<div class="card">
    <h2 class="card-header">
        <b>ตั้งค่ากลุ่ม/งาน</b>
        <div class="float-right">
            <button type="button" class="btn btn-sm btn-primary" id="add-department"><i class="fas fa-plus mr-1"></i> เพิ่ม</button>
        </div>
    </h2>
    <div class="card-body">
        <table id="departments" class="table nowrap" style="width: 100%">
            <thead class="table-light">
                <tr>
                    <th>ลำดับที่</th>
                    <th>ชื่อกลุ่ม/งาน</th>
                    <th>ชื่อย่อกลุ่ม/งาน</th>
                    <th>จำนวนผู้ดูแลระบบ</th>
                    <th>จำนวนโครงการ</th>
                    <th>ดำเนินการ</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<?php require FRONTEND_PATH . '/layouts/end.php'; ?>
