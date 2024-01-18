<?php
//For Search
$strKeyword = null;
if (isset($_GET["s"])) {
    $strKeyword = $_GET["s"];
}

if (!empty($_GET['iddp'])) {
    $valdp = $_GET['iddp'];
} else {
    $valdp = '';
}
if (!empty($_GET['date'])) {
    $valdate = $_GET['date'];
} else {
    $valdate = '';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Head -->
    <base href="/">
    <?php
    require('core/components/head.php');
    require('core/services/auth/cklogin-public.php');
    ?>
</head>

<body>
    <!-- Nav -->
    <?php require('core/components/nav.php'); ?>
    <!-- Sidebar -->
    <?php require('core/components/sidebar.php'); ?>
    <div class="wrapper">
        <div class="main-panel">
            <div class="content">
                <div class="panel-header bg-primary-gradient">
                    <div class="page-inner py-5">
                        <div class="text-center">
                            <img class="d-inline mb-3" src="fav.ico" width="100" height="100">
                            <h2 class="d-block text-white mb-1 fw-bold">ระบบพิมพ์เกียรติบัตรออนไลน์</h2>
                            <h5 class="d-inline text-white op-7 mb-2"><?= $nameschool_data ?></h5>
                        </div>
                    </div>
                </div>

                <div class="page-inner mt--5">
                    <div class="card">
                        <div class="card-body">
                            <form action="<?php echo $_SERVER['SCRIPT_NAME']; ?>" method="GET" id="form-search" name="form-search">
                                <div class="row">
                                    <div class="col-xl-6 col-xs-12">
                                        <input type="text" class="form-control" value="<?php echo $strKeyword; ?>" id="s" name="s" placeholder="ค้นหา...">
                                    </div>
                                    <?php
                                    $sql_dp = "SELECT * FROM `dp`";
                                    $query_dp = mysqli_query($con, $sql_dp) or die(mysqli_error($con));
                                    ?>
                                    <div class="col-xl-2 col-6 mt-2 mt-xl-0">
                                        <select class="form-control" id="iddp" name="iddp">
                                            <option value="" selected value="">กรุณาเลือกกลุ่ม/งาน</option>
                                            <?php foreach ($query_dp as $value_dp) { ?>
                                                <option <?= $value_dp['id'] == $valdp ? 'selected' : ''; ?> value="<?= $value_dp['id'] ?>"><?= $value_dp['name'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-xl-2 col-6 mt-2 mt-xl-0">
                                        <input type="date" value="<?= !empty($_GET['date']) ? $_GET['date'] : "" ?>" class="form-control" id="date" name="date">
                                    </div>
                                    <div class="col-xl-1 col-6 mt-2 mt-xl-0">
                                        <button type="submit" value="search" class="btn btn-block btn-primary"><i class="fas fa-search"></i></button>
                                    </div>

                                    <div class="col-xl-1 col-6 mt-2 mt-xl-0">
                                        <a href="index.php"><button type="button" class="btn btn-block btn-warning"><i class="fas fa-times"></i></button></a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <?php
                require('core/services/function.php');
                // Base query
                $query = "SELECT * FROM `project` WHERE 1";

                if (!empty($_GET['iddp'])) {
                    $query .= " AND iddp = '$valdp'";
                }

                if (!empty($_GET['date'])) {
                    $query .= " AND date = '$valdate'";
                }

                if (!empty($strKeyword)) {
                    $query .= " AND name LIKE '%" . $strKeyword . "%'";
                }

                $result = mysqli_query($con, $query) or die(mysqli_error($con));
                $num_rows = mysqli_num_rows($result);

                $per_page = 8;   // Per Page
                $page  = 1;

                if (isset($_GET["p"])) {
                    $page = $_GET["p"];
                }

                $prev_page = $page - 1;
                $next_page = $page + 1;

                $row_start = ($page - 1) * $per_page;
                $num_pages = ceil($num_rows / $per_page);

                $query .= " ORDER BY `id` DESC LIMIT {$row_start} ,{$per_page} ";
                $result = mysqli_query($con, $query) or die(mysqli_error($con));
                ?>

                <div class="row justify-content-md-center">
                    <?php
                    // path portion only with no domain and no server portions
                    $path_only = pathinfo($_SERVER['PHP_SELF'], 1);
                    // domain url portion only with no path
                    $domain_no_path = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://{$_SERVER['HTTP_HOST']}";
                    // domain url including path
                    $url =  $domain_no_path . $path_only;
                    if ($num_rows != 0) {
                        while ($row = mysqli_fetch_array($result)) {
                            if ($row["preview"] != '') {
                                $image = 'upload/preview/' . $row["preview"];
                                $imageData = base64_encode(file_get_contents($image));
                                $src = 'data: ' . ';base64,' . $imageData;
                    ?>
                                <div class="col-xl-3 col-xs-12 col-md-6 mb-4 d-flex items-stretch">
                                    <div class="card h-100">

                                        <img class="card-img-top" style="pointer-events: none;" height="100%" width="100%" src="<?= $src ?>" alt="Certificate Preview">

                                        <div class="card-body">
                                            <h6 class="card-title" style="font-size : 16px;"><?= $row["name"] ?></h6>
                                            <small class="card-text d-block" style="opacity: 0.7;">
                                                <?php
                                                $iddp = $row["iddp"];
                                                $sql_namedp = "SELECT name FROM dp WHERE id = '$iddp' ";
                                                $res_namedp = mysqli_query($con, $sql_namedp);
                                                $row_namedp = mysqli_fetch_assoc($res_namedp);
                                                echo $name["name"];
                                                ?>
                                            </small>
                                            <small class="card-text d-block" style="opacity: 0.6;"><i class="text-primary pr-1 far fa-calendar-minus"></i><?= DateThai($row["date"]) ?></small>
                                            <div class="text-center mt-1">
                                                <a href="download.php?id=<?= $row['id'] ?><?= (!empty($_GET['p']) ? "&p=" . $_GET['p'] : "") ?>"><button class="btn btn-sm btn-primary "><i class="fas fa-user mr-1"></i>รายชื่อ</button></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        <?php }
                        } ?>

                    <?php } elseif (!empty($_GET['iddp']) || !empty($_GET['date']) || !empty($strKeyword)) { ?>
                        <div class="col-12">
                            <div class="alert alert-warning text-center" role="alert">
                                ไม่พบผลการค้นหา กรุณาลองเปลี่ยนคำค้นหาใหม่อีกครั้ง (404 Not Found)
                            </div>
                        </div>
                    <?php } ?>


                    <?php if ($num_rows != 0) { ?>
                        <nav aria-label="...">
                            <ul class="pagination justify-content-center">
                                <?php
                                if ($prev_page) {
                                    $prev_url = buildPageUrl($prev_page);
                                    echo "<li class='page-item'><a tabindex='-1' class='page-link' href='$prev_url'><</a></li>";
                                }

                                if ($num_pages > 1) {
                                    echo "<li class='page-item active'><a tabindex='-1' class='page-link'>$page</a></li>";
                                }

                                if ($page != $num_pages) {
                                    $next_url = buildPageUrl($next_page);
                                    echo "<li class='page-item'><a tabindex='-1' class='page-link' href='$next_url'>></a></li>";
                                }

                                $con = null;

                                function buildPageUrl($page)
                                {
                                    $params = $_GET;
                                    $params['p'] = $page;

                                    // Customize the condition for each parameter as needed
                                    if (!empty($_GET['iddp'])) {
                                        $params['iddp'] = $_GET['iddp'];
                                    }

                                    if (!empty($_GET['date'])) {
                                        $params['date'] = $_GET['date'];
                                    }

                                    if (!empty($strKeyword)) {
                                        $params['s'] = $strKeyword;
                                    }

                                    return $_SERVER['SCRIPT_NAME'] . '?' . http_build_query($params);
                                }
                                ?>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</div>



<!-- Footer-->
<?php require('core/components/footer.php'); ?>
<!-- Script-->
<?php require('core/components/script.php'); ?>
</body>

</html>

<?php if (isset($_SESSION['msg_a'])) { ?>
    <script>
        swal("พบข้อผิดพลาด!", "<?= $_SESSION['msg_a'] ?>", {
            icon: "error",
            buttons: {
                confirm: {
                    text: "ตกลง",
                    className: 'btn btn-danger'
                }
            },
        }).then(function() {
            <?php unset($_SESSION['msg_a']) ?>
            /* location.reload();*/
        });
    </script>
<?php }; ?>