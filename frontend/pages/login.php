<?php
/**
 * หน้าเข้าสู่ระบบ (ไม่ใช้ layout หลัก)
 */
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <?php require FRONTEND_PATH . '/layouts/head.php'; ?>
    <link rel="stylesheet" href="assets/css/login.css">
</head>
<body class="text-center">
    <form class="form-signin" action="api/auth.php?action=login" method="post" data-ajax data-success="redirect" autocomplete="off">
        <?= Csrf::field() ?>

        <img class="mb-3" src="assets/img/fav.ico" alt="" width="100" height="100">
        <h2 class="h2 mb-1">ล็อกอินเข้าสู่ระบบ</h2>
        <h3 class="h4 mb-3 op-7">ระบบพิมพ์เกียรติบัตรออนไลน์</h3>

        <label for="username" class="sr-only">ชื่อผู้ใช้งาน</label>
        <input type="text" id="username" name="username" class="form-control" placeholder="ชื่อผู้ใช้งาน" maxlength="20" required autofocus>

        <label for="password" class="sr-only">รหัสผ่าน</label>
        <input type="password" id="password" name="password" class="form-control" placeholder="รหัสผ่าน" maxlength="72" required>

        <button class="btn btn-primary btn-block mt-2" type="submit">เข้าสู่ระบบ</button>

        <h5 class="mt-4 text-primary"><a href="index.php"><i class="fas fa-home"></i> กลับสู่หน้าหลัก</a></h5>
        <h5 class="mt-1">สงวนลิขสิทธิ์ &copy; <?= thai_year() ?> <?= e(School::name()) ?></h5>
    </form>

    <?php require FRONTEND_PATH . '/layouts/scripts.php'; ?>
</body>
</html>
