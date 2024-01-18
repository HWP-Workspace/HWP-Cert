<!-- Sidebar -->
<div class="sidebar sidebar-style-2">
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-primary">
                <li class="nav-item active">
                    <a href="index">
                        <i class="fas fa-home"></i>
                        <p>หน้าแรก</p>
                    </a>
                </li>
                <?php if (isset($_SESSION['token'])) { ?>
                    <ul class="nav nav-primary">
                        <li class="nav-section">
                            <span class="sidebar-mini-icon">
                                <i class="fa fa-ellipsis-h"></i>
                            </span>
                            <h4 class="text-section">แถบเมนู</h4>
                        </li>
                        <li class="nav-item">
                            <a href="admin">
                                <i class="fas fa-trophy"></i>
                                <p>โครงการ/กิจกรรม</p>
                            </a>
                        </li>
                        <?php
                        //Check if user is admin
                        if ($jwt['iddp'] == 1) { ?>
                            <li class="nav-item">
                                <a data-toggle="collapse" href="#base">
                                    <i class="fas fa-cog"></i>
                                    <p>ตั้งค่าระบบ</p>
                                    <span class="caret"></span>
                                </a>
                                <div class="collapse" id="base">
                                    <ul class="nav nav-collapse">
                                        <li>
                                            <a href="admin_config">
                                                <span class="sub-item">ตั้งค่าทั่วไป</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="admin_dp">
                                                <span class="sub-item">ตั้งค่ากลุ่ม/งาน</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="admin_user">
                                                <span class="sub-item">ตั้งค่าผู้ดูแลระบบ</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        <?php } ?>
                    </ul>
                    <li class="nav-item">
                        <a href="admin_tempate">
                            <i class="fas fa-file"></i>
                            <p>เทมเพลต</p>
                        </a>
                    </li>
                <?php } else { ?>
                    <li class="nav-section">
                        <span class="sidebar-mini-icon">
                            <i class="fa fa-ellipsis-h"></i>
                        </span>
                        <h4 class="text-section">แถบเมนู</h4>
                    </li>
                    <li class="nav-item">
                        <a href="login">
                            <i class="fas fa-lock"></i>
                            <p>ล็อกอิน</p>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</div>
<!-- End Sidebar -->