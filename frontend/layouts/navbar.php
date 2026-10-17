<?php $user = Auth::user(); ?>
<div class="main-header">
    <div class="logo-header" data-background-color="blue">
        <a href="index.php" class="logo"></a>
        <button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse" data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"><i class="icon-menu"></i></span>
        </button>
        <?php if ($user): ?>
            <button class="topbar-toggler more"><i class="icon-options-vertical"></i></button>
        <?php endif; ?>
        <div class="nav-toggle">
            <button class="btn btn-toggle toggle-sidebar"><i class="icon-menu"></i></button>
        </div>
    </div>

    <nav class="navbar navbar-header navbar-expand-lg" data-background-color="blue2">
        <?php if ($user): ?>
            <div class="container-fluid">
                <ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
                    <li class="nav-item dropdown hidden-caret">
                        <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false">
                            <div class="avatar-sm">
                                <img src="assets/img/avatar-default.png" alt="profile" class="avatar-img rounded-circle">
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-user animated fadeIn">
                            <div class="dropdown-user-scroll scrollbar-outer">
                                <li>
                                    <div class="user-box">
                                        <div class="avatar-lg"><img src="assets/img/avatar-default.png" alt="profile" class="avatar-img rounded-circle"></div>
                                        <div class="u-text">
                                            <h6 class="mb-0 pt-2"><?= e($user['name']) ?></h6>
                                            <small class="text-muted mt-0 mb-0"><?= e($user['shortdp']) ?></small>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="dropdown-divider"></div>
                                    <form action="logout.php" method="post" class="text-center">
                                        <?= Csrf::field() ?>
                                        <button type="submit" class="dropdown-item text-center">
                                            <h6 class="mb-0"><i class="fas fa-power-off text-danger"></i> ออกจากระบบ</h6>
                                        </button>
                                    </form>
                                </li>
                            </div>
                        </ul>
                    </li>
                </ul>
            </div>
        <?php endif; ?>
    </nav>
</div>
