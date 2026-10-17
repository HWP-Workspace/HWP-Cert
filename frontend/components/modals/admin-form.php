<?php
/**
 * ฟอร์มเพิ่ม/แก้ไขผู้ดูแลระบบ — ส่วนที่มี data-mode จะแสดงเฉพาะโหมดนั้น (ดู App.openForm)
 */
?>
<div class="modal fade" id="admin-modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"></h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="ปิด"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form method="post" data-ajax data-success="table:#admins" autocomplete="off">
                    <input type="hidden" name="id">

                    <div class="mb-3" data-mode="create">
                        <label class="form-label" for="admin-username">ชื่อผู้ใช้</label>
                        <input type="text" class="form-control" id="admin-username" name="username" placeholder="ชื่อผู้ใช้" minlength="5" maxlength="20" pattern="[A-Za-z0-9_.\-]{5,20}" required>
                        <small class="form-text">ภาษาอังกฤษ ตัวเลข หรือ _ . - ความยาว 5-20 ตัวอักษร และต้องไม่ซ้ำกับผู้อื่น</small>
                    </div>
                    <div class="mb-3" data-mode="edit">
                        <label class="form-label" for="admin-username-readonly">ชื่อผู้ใช้</label>
                        <input type="text" class="form-control" id="admin-username-readonly" name="username" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="admin-name">ชื่อผู้ดูแล</label>
                        <input type="text" class="form-control" id="admin-name" name="name" maxlength="100" placeholder="ชื่อผู้ดูแล" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="admin-department">กลุ่ม/งาน</label>
                        <select class="form-control" id="admin-department" name="iddp" required>
                            <option value="">กรุณาเลือกกลุ่ม/งาน</option>
                            <?php foreach (Department::all() as $department): ?>
                                <option value="<?= (int) $department['id'] ?>"><?= e($department['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <hr>
                    <div data-mode="create">
                        <div class="mb-3">
                            <label class="form-label" for="admin-password">รหัสผ่าน</label>
                            <input type="password" class="form-control" id="admin-password" name="password" placeholder="รหัสผ่าน" minlength="8" maxlength="72" autocomplete="new-password" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="admin-password-confirmation">ยืนยันรหัสผ่าน</label>
                            <input type="password" class="form-control" id="admin-password-confirmation" name="password_confirmation" placeholder="ยืนยันรหัสผ่าน" minlength="8" maxlength="72" autocomplete="new-password" required>
                        </div>
                    </div>
                    <div class="mb-3" data-mode="edit">
                        <label class="form-label" for="admin-new-password">รหัสผ่านใหม่ (เว้นว่างหากไม่ต้องการเปลี่ยน)</label>
                        <input type="password" class="form-control" id="admin-new-password" name="password" minlength="8" maxlength="72" autocomplete="new-password">
                    </div>

                    <div class="text-center">
                        <button class="btn btn-primary" type="submit"><i class="fas fa-save"></i> บันทึก</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
