<?php
/** @var array $project */
?>
<div class="modal fade" id="import-modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">นำเข้ารายชื่อ</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="ปิด"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form action="api/participants.php?action=import" method="post" enctype="multipart/form-data" data-ajax data-success="table:#participants">
                    <input type="hidden" name="project" value="<?= (int) $project['id'] ?>">

                    <label class="form-label" for="import-file">กรุณาอัปโหลดไฟล์ .csv (UTF-8) หรือ .xlsx เท่านั้น</label>
                    <div class="input-group mb-3 mt-1">
                        <div class="input-group-prepend"><span class="input-group-text">อัปโหลด</span></div>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="import-file" name="file" accept=".xlsx,.csv" data-max-bytes="<?= ParticipantImporter::MAX_BYTES ?>" required>
                            <label class="custom-file-label" for="import-file">เลือกไฟล์</label>
                        </div>
                    </div>

                    <label class="form-label mr-2">ตัวอย่างไฟล์</label>
                    <a class="text-success" href="downloads/excel/example.csv"><i class="fas fa-file-excel"></i> example.csv</a>
                    <a class="text-success ml-3" href="downloads/excel/example.xlsx"><i class="fas fa-file-excel"></i> example.xlsx</a>

                    <div class="text-center mt-3">
                        <button class="btn btn-primary" type="submit"><i class="fas fa-file-import"></i> นำเข้า</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
