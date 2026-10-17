<?php
/**
 * หน้าแรก — รายการโครงการที่เผยแพร่แล้ว
 *
 * @var array    $filters      ['s', 'iddp', 'date']
 * @var array    $projects
 * @var array    $departments
 * @var int      $currentPage
 * @var int      $totalPages
 * @var bool     $isFiltered
 * @var callable $pageUrl      function (int $page): string
 */
require FRONTEND_PATH . '/layouts/start.php';
?>

<div class="card">
    <div class="card-body">
        <form action="index.php" method="get">
            <div class="row">
                <div class="col-xl-6 col-12">
                    <input type="text" class="form-control" name="s" value="<?= e($filters['s']) ?>" placeholder="ค้นหา...">
                </div>
                <div class="col-xl-2 col-6 mt-2 mt-xl-0">
                    <select class="form-control" name="iddp">
                        <option value="">กรุณาเลือกกลุ่ม/งาน</option>
                        <?php foreach ($departments as $department): ?>
                            <option value="<?= (int) $department['id'] ?>"<?= (int) $department['id'] === $filters['iddp'] ? ' selected' : '' ?>><?= e($department['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-xl-2 col-6 mt-2 mt-xl-0">
                    <input type="date" class="form-control" name="date" value="<?= e($filters['date']) ?>">
                </div>
                <div class="col-xl-1 col-6 mt-2 mt-xl-0">
                    <button type="submit" class="btn btn-block btn-primary" title="ค้นหา"><i class="fas fa-search"></i></button>
                </div>
                <div class="col-xl-1 col-6 mt-2 mt-xl-0">
                    <a href="index.php" class="btn btn-block btn-warning" title="ล้างการค้นหา"><i class="fas fa-times"></i></a>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="row justify-content-md-center">
    <?php foreach ($projects as $project): ?>
        <div class="col-xl-3 col-md-6 col-12 mb-4 d-flex">
            <div class="card h-100 w-100">
                <img class="card-img-top" style="pointer-events: none;" src="<?= e(TemplateStorage::previewDataUri($project['preview'])) ?>" alt="ตัวอย่างเกียรติบัตร">
                <div class="card-body">
                    <h6 class="card-title" style="font-size: 16px;"><?= e($project['name']) ?></h6>
                    <small class="card-text d-block op-7"><?= e($project['dp_name']) ?></small>
                    <small class="card-text d-block op-7"><i class="text-primary pr-1 far fa-calendar-minus"></i><?= thai_date($project['date']) ?></small>
                    <div class="text-center mt-1">
                        <a href="download.php?id=<?= (int) $project['id'] ?>&amp;p=<?= $currentPage ?>" class="btn btn-sm btn-primary">
                            <i class="fas fa-user mr-1"></i>รายชื่อ
                        </a>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

    <?php if (!$projects && $isFiltered): ?>
        <div class="col-12">
            <div class="alert alert-warning text-center" role="alert">ไม่พบผลการค้นหา กรุณาลองเปลี่ยนคำค้นหาใหม่อีกครั้ง</div>
        </div>
    <?php endif; ?>
</div>

<?php if ($totalPages > 1): ?>
    <nav aria-label="เปลี่ยนหน้า">
        <ul class="pagination justify-content-center">
            <?php if ($currentPage > 1): ?>
                <li class="page-item"><a class="page-link" href="<?= e($pageUrl($currentPage - 1)) ?>">&lt;</a></li>
            <?php endif; ?>
            <li class="page-item active"><span class="page-link"><?= $currentPage ?> / <?= $totalPages ?></span></li>
            <?php if ($currentPage < $totalPages): ?>
                <li class="page-item"><a class="page-link" href="<?= e($pageUrl($currentPage + 1)) ?>">&gt;</a></li>
            <?php endif; ?>
        </ul>
    </nav>
<?php endif; ?>

<?php require FRONTEND_PATH . '/layouts/end.php'; ?>
