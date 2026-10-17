<?php
/**
 * ตั้งค่าข้อมูลหน่วยงาน/โรงเรียน
 *
 * @var array $school
 */
require FRONTEND_PATH . '/layouts/start.php';
?>

<div class="card">
    <h2 class="card-header"><b>ตั้งค่าโครงสร้างระบบ</b></h2>
    <div class="card-body">
        <form action="api/settings.php?action=update" method="post" enctype="multipart/form-data" data-ajax data-success="reload">
            <div class="row">
                <div class="col-xl-6 col-12 mb-3">
                    <label class="form-label" for="school-name">ชื่อหน่วยงาน/โรงเรียน (ภาษาไทย) <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="school-name" name="name" value="<?= e($school['name']) ?>" maxlength="255" required>
                </div>

                <div class="col-xl-6 col-12 mb-3">
                    <label class="form-label" for="school-shortname">ชื่อย่อหน่วยงาน/โรงเรียน <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="school-shortname" name="shortname" value="<?= e($school['shortname']) ?>" maxlength="10" required>
                    <small class="form-text text-danger">ไม่จำเป็นต้องใส่ . (จุด) ต่อท้าย — ข้อมูลนี้นำไปใช้รันเลขที่เกียรติบัตร</small>
                </div>

                <div class="col-12">
                    <label for="school-logo">อัปโหลดตราสัญลักษณ์หน่วยงาน/โรงเรียน (.png, .jpg หรือ .ico ไม่เกิน 2 MB — เว้นว่างหากไม่ต้องการเปลี่ยน)</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="school-logo" name="logo" accept=".png,.jpg,.jpeg,.ico" data-max-bytes="<?= Logo::MAX_BYTES ?>">
                        <label class="custom-file-label" for="school-logo">เลือกไฟล์</label>
                    </div>

                    <div class="text-center mt-5">
                        ตราสัญลักษณ์ (ปัจจุบัน)<br>
                        <img class="mt-3" src="<?= e(Logo::url()) ?>" height="150" width="150" alt="ตราสัญลักษณ์">
                    </div>
                </div>
            </div>

            <div class="text-center pt-3">
                <button type="submit" class="btn btn-primary mt-3"><i class="fas fa-save"></i> บันทึก</button>
            </div>
        </form>
    </div>
</div>

<?php require FRONTEND_PATH . '/layouts/end.php'; ?>
