<?php
/**
 * ตั้งค่าโครงการ: รูปแบบเกียรติบัตร และรายชื่อผู้เข้าร่วม
 *
 * @var array $project
 * @var int   $projectId
 * @var int   $extraLines
 * @var array $fontSizes
 */
require FRONTEND_PATH . '/layouts/start.php';
?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body text-center">
                <h2><b>โครงการ : <?= e($project['name']) ?></b></h2>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-12">
        <div class="card">
            <h3 class="card-header"><b>ตั้งค่ารูปแบบเกียรติบัตร</b></h3>
            <div class="card-body">
                <form action="api/projects.php?action=style" method="post" data-ajax>
                    <input type="hidden" name="id" value="<?= $projectId ?>">

                    <div class="form-group mb-3">
                        <label for="style-font">ฟอนต์</label>
                        <select class="form-control" id="style-font" name="font">
                            <?php foreach (Project::FONTS as $value => $label): ?>
                                <option value="<?= e($value) ?>"<?= $project['font'] === $value ? ' selected' : '' ?>><?= e($label) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group range-wrap mb-5">
                        <label for="style-margin">ระยะขอบ <small class="text-danger">[px]</small></label>
                        <input type="range" class="form-control-range range" id="style-margin" name="margin" min="0" max="1000" value="<?= (int) $project['margin'] ?>">
                        <output class="bubble"></output>
                    </div>

                    <div class="form-group mb-3">
                        <label for="style-color">สีฟอนต์</label>
                        <input type="text" class="form-control" id="style-color" name="color" value="<?= e($project['color']) ?>" required>
                    </div>

                    <?php foreach ($fontSizes as list($field, $label)): ?>
                        <div class="form-group range-wrap mb-5">
                            <label for="style-<?= $field ?>"><?= $label ?> <small class="text-danger">[px]</small></label>
                            <input type="range" class="form-control-range range" id="style-<?= $field ?>" name="<?= $field ?>" min="0" max="144" value="<?= (int) $project[$field] ?>">
                            <output class="bubble"></output>
                        </div>
                    <?php endforeach; ?>

                    <div class="text-center">
                        <button class="btn btn-primary btn-sm" type="submit"><i class="fas fa-save"></i> บันทึก</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-xl-8 col-12">
        <div class="card">
            <h3 class="card-header">
                <b>รายชื่อผู้เข้าร่วม</b>
                <div class="float-right mt-3 mt-md-0">
                    <button type="button" class="btn btn-sm btn-primary" id="add-participant"><i class="fas fa-plus mr-1"></i> เพิ่ม</button>
                    <button type="button" class="btn btn-sm btn-info ml-2" data-toggle="modal" data-target="#template-modal"><i class="fas fa-file-upload mr-1"></i> อัปโหลดแม่แบบ</button>
                    <button type="button" class="btn btn-sm btn-success ml-2" data-toggle="modal" data-target="#import-modal"><i class="fas fa-file-import mr-1"></i> นำเข้า</button>
                    <button type="button" class="btn btn-sm btn-danger ml-2" id="delete-all-participants"><i class="fas fa-trash mr-1"></i> ลบทั้งหมด</button>
                </div>
            </h3>
            <div class="card-body">
                <table id="participants" class="table nowrap" style="width: 100%">
                    <thead class="table-light">
                        <tr>
                            <th>ลำดับที่</th>
                            <th>ชื่อ - นามสกุล</th>
                            <th>รหัสเกียรติบัตร</th>
                            <th>ดำเนินการ</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require FRONTEND_PATH . '/layouts/end.php'; ?>
