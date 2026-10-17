<?php
/**
 * ตั้งค่าผู้ดูแลระบบ
 */
require FRONTEND_PATH . '/layouts/start.php';
?>

<div class="card">
    <h2 class="card-header">
        <b>ตั้งค่าผู้ดูแลระบบ</b>
        <div class="float-right">
            <button type="button" class="btn btn-sm btn-primary" id="add-admin"><i class="fas fa-plus mr-1"></i> เพิ่ม</button>
        </div>
    </h2>
    <div class="card-body">
        <table id="admins" class="table nowrap" style="width: 100%">
            <thead class="table-light">
                <tr>
                    <th>ลำดับที่</th>
                    <th>ชื่อผู้ดูแล</th>
                    <th>ชื่อผู้ใช้</th>
                    <th>กลุ่ม/งาน</th>
                    <th>ชื่อย่อกลุ่ม/งาน</th>
                    <th>ดำเนินการ</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<?php require FRONTEND_PATH . '/layouts/end.php'; ?>
