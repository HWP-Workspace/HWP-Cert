<?php
/**
 * @var array $page ['active' => key ของเมนูที่เลือก, 'back' => URL ปุ่มย้อนกลับ (ไม่บังคับ)]
 */
$active = isset($page['active']) ? $page['active'] : '';
$isActive = function ($key) use ($active) {
    return $active === $key || strpos($active, $key . '.') === 0 ? ' active' : '';
};
$settingsMenu = [
    'settings.general'     => ['admin_config.php', 'ตั้งค่าทั่วไป'],
    'settings.departments' => ['admin_dp.php', 'ตั้งค่ากลุ่ม/งาน'],
    'settings.admins'      => ['admin_user.php', 'ตั้งค่าผู้ดูแลระบบ'],
];
?>
<div class="sidebar sidebar-style-2">
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-primary">
                <?php if (!empty($page['back'])): ?>
                    <li class="nav-item active">
                        <a href="<?= e($page['back']) ?>"><i class="fas fa-arrow-left"></i><p>ย้อนกลับ</p></a>
                    </li>
                <?php else: ?>
                    <li class="nav-item<?= $isActive('home') ?>">
                        <a href="index.php"><i class="fas fa-home"></i><p>หน้าแรก</p></a>
                    </li>
                <?php endif; ?>

                <li class="nav-section">
                    <span class="sidebar-mini-icon"><i class="fa fa-ellipsis-h"></i></span>
                    <h4 class="text-section">แถบเมนู</h4>
                </li>

                <?php if (Auth::check()): ?>
                    <li class="nav-item<?= $isActive('projects') ?>">
                        <a href="admin.php"><i class="fas fa-trophy"></i><p>โครงการ/กิจกรรม</p></a>
                    </li>

                    <?php if (Auth::isSuperAdmin()): ?>
                        <li class="nav-item<?= $isActive('settings') ?>">
                            <a data-toggle="collapse" href="#settings-menu">
                                <i class="fas fa-cog"></i><p>ตั้งค่าระบบ</p><span class="caret"></span>
                            </a>
                            <div class="collapse<?= $isActive('settings') ? ' show' : '' ?>" id="settings-menu">
                                <ul class="nav nav-collapse">
                                    <?php foreach ($settingsMenu as $key => list($url, $label)): ?>
                                        <li class="<?= trim($isActive($key)) ?>">
                                            <a href="<?= $url ?>"><span class="sub-item"><?= $label ?></span></a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </li>
                    <?php endif; ?>

                    <li class="nav-item<?= $isActive('templates') ?>">
                        <a href="admin_tempate.php"><i class="fas fa-file"></i><p>เทมเพลต</p></a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a href="login.php"><i class="fas fa-lock"></i><p>ล็อกอิน</p></a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</div>
