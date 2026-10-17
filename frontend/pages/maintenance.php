<?php
/**
 * แสดงเมื่อระบบรอการอัปเดตฐานข้อมูล แต่ผู้ใช้ที่ล็อกอินอยู่ไม่ใช่ผู้ดูแลระบบสูงสุด
 *
 * @var string $pageTitle
 */
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <?php require FRONTEND_PATH . '/layouts/head.php'; ?>
</head>
<body class="bg-light">
<div class="container py-5 text-center" style="max-width: 560px;">
    <img src="<?= e(Logo::url()) ?>" width="80" height="80" alt="">
    <div class="card mt-4">
        <div class="card-body py-5">
            <i class="fas fa-tools fa-3x text-warning mb-3"></i>
            <h3 class="fw-bold">ระบบกำลังรอการอัปเดต</h3>
            <p class="op-7 mb-4">กรุณาติดต่อผู้ดูแลระบบสูงสุด (admin) ให้เข้าสู่ระบบเพื่ออัปเดตฐานข้อมูล</p>
            <form action="logout.php" method="post">
                <?= Csrf::field() ?>
                <button type="submit" class="btn btn-secondary"><i class="fas fa-power-off mr-1"></i> ออกจากระบบ</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
