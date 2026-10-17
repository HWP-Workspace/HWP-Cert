<?php
/**
 * @var array $project
 * @var int   $extraLines
 */
?>
<div class="modal fade" id="participant-modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"></h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="ปิด"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form method="post" data-ajax data-success="table:#participants">
                    <input type="hidden" name="id">
                    <input type="hidden" name="project" value="<?= (int) $project['id'] ?>">

                    <div class="mb-3">
                        <label class="form-label" for="participant-name">ชื่อ-นามสกุล</label>
                        <input class="form-control" type="text" id="participant-name" name="name" maxlength="255" placeholder="ชื่อ-นามสกุล" required>
                    </div>

                    <?php for ($line = 2; $line <= $extraLines + 1; $line++): ?>
                        <div class="mb-3">
                            <label class="form-label" for="participant-line<?= $line ?>">บรรทัด <?= $line ?></label>
                            <input class="form-control" type="text" id="participant-line<?= $line ?>" name="line<?= $line ?>" maxlength="255" placeholder="บรรทัด <?= $line ?>">
                        </div>
                    <?php endfor; ?>

                    <div class="text-center">
                        <button class="btn btn-primary" type="submit"><i class="fas fa-save"></i> บันทึก</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
