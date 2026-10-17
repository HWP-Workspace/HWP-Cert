<?php
/**
 * ดาวน์โหลดไฟล์เทมเพลตเกียรติบัตร (.psd)
 *
 * @var array $templates
 */
require FRONTEND_PATH . '/layouts/start.php';
?>

<div class="card">
    <h2 class="card-header"><b>ไฟล์เทมเพลตเกียรติบัตร (.psd)</b></h2>
    <div class="card-body">
        <div class="text-center">
            <img class="img-cert" src="assets/img/img_excert.jpg" alt="ตัวอย่างเทมเพลตเกียรติบัตร" width="390" height="290">
        </div>
        <div class="row text-center pt-3">
            <?php foreach ($templates as $file => $label): ?>
                <div class="col">
                    <h6><?= $label ?></h6>
                    <a href="downloads/templates/<?= $file ?>" class="btn btn-sm btn-primary" download>
                        <i class="fas fa-file-download"></i> ดาวน์โหลด
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php require FRONTEND_PATH . '/layouts/end.php'; ?>
