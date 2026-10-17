<div class="modal fade" id="department-modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"></h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="ปิด"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form method="post" data-ajax data-success="table:#departments">
                    <input type="hidden" name="id">

                    <div class="mb-3">
                        <label class="form-label" for="department-name">ชื่อกลุ่ม/งาน</label>
                        <input type="text" class="form-control" id="department-name" name="name" maxlength="255" placeholder="ชื่อกลุ่ม/งาน" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="department-short">ชื่อย่อกลุ่ม/งาน</label>
                        <input type="text" class="form-control" id="department-short" name="shortdp" maxlength="50" placeholder="ชื่อย่อกลุ่ม/งาน" required>
                        <small class="form-text text-danger">ข้อมูลนี้นำไปใช้รันเลขที่เกียรติบัตร</small>
                    </div>

                    <div class="text-center">
                        <button class="btn btn-primary" type="submit"><i class="fas fa-save"></i> บันทึก</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
