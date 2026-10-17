<div class="modal fade" id="project-modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"></h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="ปิด"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form method="post" data-ajax data-success="table:#projects">
                    <input type="hidden" name="id">

                    <div class="mb-3">
                        <label class="form-label" for="project-name">ชื่อโครงการ/กิจกรรม</label>
                        <input class="form-control" type="text" id="project-name" name="name" maxlength="255" placeholder="โครงการ/กิจกรรม" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="project-date">วันที่</label>
                        <input class="form-control" type="date" id="project-date" name="date" required>
                        <small>กรุณากรอกเป็น ค.ศ. ระบบจะแปลงเป็น พ.ศ. ให้อัตโนมัติ</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="project-type">รูปแบบ</label>
                        <select class="form-control" id="project-type" name="type">
                            <?php foreach (Project::TYPES as $value => $label): ?>
                                <option value="<?= $value ?>"><?= e($label) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <?php if (Auth::isSuperAdmin()): ?>
                        <div class="mb-3">
                            <label class="form-label" for="project-department">กลุ่ม/งาน</label>
                            <select class="form-control" id="project-department" name="iddp" required>
                                <option value="">กรุณาเลือกกลุ่ม/งาน</option>
                                <?php foreach (Department::all() as $department): ?>
                                    <option value="<?= (int) $department['id'] ?>"><?= e($department['name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    <?php endif; ?>

                    <div class="text-center">
                        <button class="btn btn-primary" type="submit"><i class="fas fa-save"></i> บันทึก</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
