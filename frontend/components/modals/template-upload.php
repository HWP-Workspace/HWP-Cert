<?php
/** @var array $project */
?>
<div class="modal fade" id="template-modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">อัปโหลดแม่แบบเกียรติบัตร</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="ปิด"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form action="api/projects.php?action=template" method="post" enctype="multipart/form-data" data-ajax data-success="reload">
                    <input type="hidden" name="id" value="<?= (int) $project['id'] ?>">

                    <label class="form-label mb-1" for="template-file">
                        กรุณาอัปโหลดไฟล์เทมเพลต .jpg, .jpeg, .png เท่านั้น <span class="text-danger">(ไม่เกิน 2 MB)</span>
                    </label>
                    <div class="input-group mb-1">
                        <div class="input-group-prepend"><span class="input-group-text">อัปโหลด</span></div>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="template-file" name="template" accept=".jpg,.jpeg,.png" data-max-bytes="<?= TemplateStorage::MAX_BYTES ?>" required>
                            <label class="custom-file-label" for="template-file">เลือกไฟล์</label>
                        </div>
                    </div>
                    <small class="text-primary">ขนาด A4 แนวนอน (21 x 29.7 cm) เท่านั้น</small>

                    <?php if (Project::isPublished($project)): ?>
                        <div class="mb-2 mt-3">แม่แบบปัจจุบัน :</div>
                        <img class="img-cert" src="api/projects.php?action=template_image&amp;id=<?= (int) $project['id'] ?>" alt="แม่แบบเกียรติบัตร">
                    <?php endif; ?>

                    <div class="text-center mt-3">
                        <button class="btn btn-primary" type="submit"><i class="fas fa-file-upload"></i> อัปโหลด</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
