
<!DOCTYPE html>
<html lang="en">
<head>

<!-- Head -->
<?php 
session_start();
require('structure/head.php'); 

$strKeyword = null;

if(isset($_GET["s"])){
    $strKeyword = $_GET["s"];
}

    if(!empty($_GET['iddp'])){
        $valdp = $_GET['iddp'];
    }else{
        $valdp = '';
    }
    if(!empty($_GET['date'])){
        $valdate = $_GET['date'];
    }else{
        $valdate = '';
    }
    
?>
</head>
<body>

<!-- Nav -->
<?php require('structure/nav.php'); ?>


		<!-- Sidebar -->
		<div class="sidebar sidebar-style-2">			
			<div class="sidebar-wrapper scrollbar scrollbar-inner">
						<div class="sidebar-content">

							<ul class="nav nav-secondary">
								<li class="nav-item active">
									<a href="index.php">
										<i class="fas fa-home"></i>
										<p>หน้าแรก</p>
									</a>
								</li>

                                <?php if(isset($_SESSION['username'])) { ?>
                                    
                                <ul class="nav nav-secondary">
								<li class="nav-section">
									<span class="sidebar-mini-icon">
										<i class="fa fa-ellipsis-h"></i>
									</span>
									<h4 class="text-section">แถบเมนู</h4>
								</li>
                                <li class="nav-item">
									<a href="admin.php">
										<i class="fas fa-trophy"></i>
										<p>โครงการ/กิจกรรม</p>
									</a>
								</li>
                                <?php if($_SESSION['username'] == "admin"){ ?>
                                <li class="nav-item">
									<a data-toggle="collapse" href="#base">
									<i class="fas fa-cog"></i>
										<p>ตั้งค่าระบบ</p>
										<span class="caret"></span>
									</a>
									<div class="collapse" id="base">
										<ul class="nav nav-collapse">
											<li>
												<a href="admin_config.php">
													<span class="sub-item">ตั้งค่าทั่วไป</span>
												</a>
											</li>

                                            <li>
												<a href="admin_dp.php">
													<span class="sub-item">ตั้งค่ากลุ่ม/งาน</span>
												</a>
											</li>

											<li>
												<a href="admin_user.php">
													<span class="sub-item">ตั้งค่าผู้ดูแลระบบ</span>
												</a>
											</li>

											</li>
										</ul>
									</div>
								</li>
                                <?php } ?>

                                <li class="nav-item">
									<a href="admin_tempate.php" >
										<i class="fas fa-file"></i>
										<p>เทมเพลต</p>
									</a>
								</li>

                                <?php } else{ ?>

                                    <li class="nav-section">
									<span class="sidebar-mini-icon">
										<i class="fa fa-ellipsis-h"></i>
									</span>
									<h4 class="text-section">แถบเมนู</h4>
								</li>

								<li class="nav-item">
									<a data-toggle="modal" data-target="#login" >
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

		<div class="main-panel">
			<div class="content">
				<div class="panel-header bg-secondary-gradient">
					<div class="page-inner py-5">
						<div class="text-center">

							<div>
							<img class="d-inline mb-3" src="img/fav.ico" width="100" height="100">
							</div>

							<div>

								<h2 class="d-block text-white mb-1 fw-bold">ระบบพิมพ์เกียรติบัตรออนไลน์</h2>
								<h5 class="d-inline text-white op-7 mb-2"><?= $nameschool_data ?></h5>
							</div>
						</div>
					</div>
				</div>
				<div class="page-inner mt--5">
                    <div class="card">
                    <div class="card-body">

                    <form action="<?php echo $_SERVER['SCRIPT_NAME'];?>" method="GET" id="form-search" name="form-search">
                    <div class="row">
                        <div class="col-xl-6 col-xs-12">
                            <input type="text" class="form-control"  value="<?php echo $strKeyword;?>" id="s" name="s" placeholder="ค้นหา...">
                        </div>

                        <?php
                        $sql_dp = "SELECT * FROM `dp`";
                        $query_dp = mysqli_query($con, $sql_dp);
                        if (false === $query_dp) {
                            die(mysqli_error($con));
                        }
                        
                        ?>

                    
                        <div class="col-xl-2 col-6 mt-2 mt-xl-0">
                            <select class="form-control" id="iddp" name="iddp">
                            <option value=""  selected value="">กรุณาเลือกกลุ่ม/งาน</option>
                                <?php foreach ($query_dp as $value_dp) { ?>
                                	<option <?php echo $value_dp['id'] == $valdp ? ' selected ' : '';?> value="<?=$value_dp['id']?>"><?=$value_dp['name']?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="col-xl-2 col-6 mt-2 mt-xl-0">
                            <input type="date" value="<?php if(!empty($_GET['date'])){echo $_GET['date'];}?>" class="form-control" id="date" name="date">
                        </div>
                    

                        <div class="col-xl-1 col-6 mt-2 mt-xl-0">
                        <button type="submit" value="search" class="btn btn-block btn-primary">ค้นหา</button>
                        </div>

                        <div class="col-xl-1 col-6 mt-2 mt-xl-0">
                        <a href="index.php"><button type="button" class="btn btn-block btn-warning">ล้างค่า</button></a>
                        </div>

                    </div>

                       
                    

                    </form>

                    </div>
                    </div>
                   
                <?php 
                require('structure/datethai.php');
                if(!empty($_GET['iddp']) && empty($_GET['date']) && empty($strKeyword)){
                $query = "SELECT * FROM `project` WHERE iddp = '$valdp' " or die("Error:" . mysqli_error());
                }
                elseif(empty($_GET['iddp']) && !empty($_GET['date']) && empty($strKeyword)){
                $query = "SELECT * FROM `project` WHERE date = '$valdate' " or die("Error:" . mysqli_error());
                }
                elseif(empty($_GET['iddp']) && empty($_GET['date']) && !empty($strKeyword)){
                $query = "SELECT * FROM `project` WHERE name LIKE '%".$strKeyword."%' " or die("Error:" . mysqli_error());
                }
                elseif(!empty($_GET['iddp']) && !empty($_GET['date']) && empty($strKeyword)){
                $query = "SELECT * FROM `project` WHERE date = '$valdate' AND iddp = '$valdp' " or die("Error:" . mysqli_error());
                }
                elseif(empty($_GET['iddp']) && !empty($_GET['date']) && !empty($strKeyword)){
                $query = "SELECT * FROM `project` WHERE name LIKE '%".$strKeyword."%' AND date = '$valdate'" or die("Error:" . mysqli_error());
                }
                elseif(!empty($_GET['iddp']) && empty($_GET['date']) && !empty($strKeyword)){
                $query = "SELECT * FROM `project` WHERE name LIKE '%".$strKeyword."%' AND iddp = '$valdp'" or die("Error:" . mysqli_error());
                }
                elseif(!empty($_GET['iddp']) && !empty($_GET['date']) && !empty($strKeyword)){
                $query = "SELECT * FROM `project` WHERE name LIKE '%".$strKeyword."%' AND iddp = '$valdp' AND date = '$valdate' " or die("Error:" . mysqli_error());
                }
                else{
                $query = "SELECT * FROM `project` " or die("Error:" . mysqli_error());
                }

                $result = mysqli_query($con, $query);
                $num_rows = mysqli_num_rows($result);

                $per_page = 8;   // Per Page
                $page  = 1;
                
                if(isset($_GET["p"]))
                {
                    $page = $_GET["p"];
                }

                $prev_page = $page-1;
                $next_page = $page+1;

                $row_start = ($page - 1) * $per_page;
                $num_pages = ceil($num_rows / $per_page);                                        

                $query .= "ORDER BY `id` DESC LIMIT {$row_start} ,{$per_page} ";
                $result = mysqli_query($con, $query);
                ?>

                <div class="row justify-content-md-center">
                <?php 

                // path portion only with no domain and no server portions
                $path_only = pathinfo($_SERVER['PHP_SELF'], 1); 

                // domain url portion only with no path
                $domain_no_path = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://{$_SERVER['HTTP_HOST']}"; 

                // domain url including path
                $url =  $domain_no_path.$path_only;
                if($num_rows != 0){ 
                while($row = mysqli_fetch_array($result)){ 
                    if($row["preview"] != ''){
                        $image = ''.$url.'/upload/preview/' .$row["preview"].'';
                        $imageData = base64_encode(file_get_contents($image));
                        $src = 'data: ' . ';base64,' . $imageData;
                    ?> 

                        <div class="col-xl-3 col-xs-12 col-md-6 mb-4 d-flex items-stretch">   
                            <div class="card h-100">
                                
                            <img class="card-img-top" style="pointer-events: none;" height="100%" width="100%" src="<?=$src?>" alt="Certificate Preview">
                    
                            <div class="card-body">
                                <h6 class="card-title" style="font-size : 16px;"><?=$row["name"]?></h6>
                                <small class="card-text d-block" style="opacity: 0.7;"><?php 
                                 $iddp = $row["iddp"];
                                 $sql_namedp = "SELECT * FROM dp WHERE id = '$iddp' ";
                                 $res_namedp = mysqli_query($con, $sql_namedp);
                                 while ($row_namedp = mysqli_fetch_assoc($res_namedp)) {
                                     $name = $row_namedp['name'];
                                     break;
                                 }
                                 echo $name;
                                ?></small>
                                <small class="card-text d-block" style="opacity: 0.6;"><i class="text-primary pr-1 far fa-calendar-minus"></i><?=DateThai($row["date"])?></small>
                                
                                <div class="text-center mt-1">
                                <button onclick="UserRow(<?=$row['id']?>)" class="btn btn-sm btn-primary "><i class="fas fa-user"></i> รายชื่อ</button>
                                </div>
                            </div>
                            </div>
                        </div>                    
                    <?php } } ?>

                <?php } elseif(!empty($_GET['iddp']) || !empty($_GET['date']) || !empty($strKeyword)){ ?>
                    <div class="col-12">
                    <div class="alert alert-warning text-center" role="alert">
                        ไม่พบผลการค้นหา กรุณาลองเปลี่ยนคำค้นหาใหม่อีกครั้ง (404 Not Found)
                    </div>
                    </div>
                <?php }else{} ?>    
                    </div>

            <?php if($num_rows != 0){ ?>
                <nav aria-label="...">
                 <ul class="pagination justify-content-center">
                    <?php
                    
                    if($prev_page)
                    {

                        if(!empty($_GET['iddp']) && empty($_GET['date']) && empty($strKeyword)){
                        echo "
                        <li class='page-item'>
                        <a tabindex='-1' class='page-link' href='$_SERVER[SCRIPT_NAME]?iddp=$valdp&p=$prev_page'><</a>
                        </li>";
                        }
                        elseif(empty($_GET['iddp']) && !empty($_GET['date']) && empty($strKeyword)){
                        echo "
                        <li class='page-item'>
                        <a tabindex='-1' class='page-link' href='$_SERVER[SCRIPT_NAME]?date=$valdate&p=$prev_page'><</a>
                        </li>";
                        }
                        elseif(empty($_GET['iddp']) && empty($_GET['date']) && !empty($strKeyword)){
                        echo "
                        <li class='page-item'>
                        <a tabindex='-1' class='page-link' href='$_SERVER[SCRIPT_NAME]?s=$strKeyword&p=$prev_page'><</a>
                        </li>";
                        }
                        elseif(!empty($_GET['iddp']) && !empty($_GET['date']) && empty($strKeyword)){
                        echo "
                        <li class='page-item'>
                        <a tabindex='-1' class='page-link' href='$_SERVER[SCRIPT_NAME]?iddp=$valdp&date=$valdate&p=$prev_page'><</a>
                        </li>";
                        }
                        elseif(empty($_GET['iddp']) && !empty($_GET['date']) && !empty($strKeyword)){
                        echo "
                        <li class='page-item'>
                        <a tabindex='-1' class='page-link' href='$_SERVER[SCRIPT_NAME]?s=$strKeyword&date=$valdate&p=$prev_page'><</a>
                        </li>";
                        }
                        elseif(!empty($_GET['iddp']) && empty($_GET['date']) && !empty($strKeyword)){
                        echo "
                        <li class='page-item'>
                        <a tabindex='-1' class='page-link' href='$_SERVER[SCRIPT_NAME]?s=$strKeyword&iddp=$valdp'><</a>
                        </li>";
                        }
                        elseif(!empty($_GET['iddp']) && !empty($_GET['date']) && !empty($strKeyword)){
                        echo "
                        <li class='page-item'>
                        <a tabindex='-1' class='page-link' href='$_SERVER[SCRIPT_NAME]?s=$strKeyword&iddp=$valdp&date=$valdate'><</a>
                        </li>";
                        }
                        else{
                                echo "
                                <li class='page-item'>
                                <a tabindex='-1' class='page-link' href='$_SERVER[SCRIPT_NAME]?p=$prev_page'><</a>
                                </li>";
                        }   
                    }
                    if($num_pages > 1){
                        echo "<li class='page-item active'><a tabindex='-1' class='page-link' >$page</a></li>";
                    }
                    if($page != $num_pages)
                    {
                        if(!empty($_GET['iddp']) && empty($_GET['date']) && empty($strKeyword)){
                            echo "
                            <li class='page-item'>
                            <a tabindex='-1' class='page-link' href='$_SERVER[SCRIPT_NAME]?iddp=$valdp&p=$next_page'>></a>
                            </li>";
                        }
                        elseif(empty($_GET['iddp']) && !empty($_GET['date']) && empty($strKeyword)){
                            echo "
                            <li class='page-item'>
                            <a tabindex='-1' class='page-link' href='$_SERVER[SCRIPT_NAME]?date=$valdate&p=$next_page'>></a>
                            </li>";
                        }
                        elseif(empty($_GET['iddp']) && empty($_GET['date']) && !empty($strKeyword)){
                        echo "
                        <li class='page-item'>
                        <a class='page-link' href='$_SERVER[SCRIPT_NAME]&s=$strKeyword'>></a>
                        </li>";
                        }
                        elseif(!empty($_GET['iddp']) && !empty($_GET['date']) && empty($strKeyword)){
                            echo "
                            <li class='page-item'>
                            <a tabindex='-1' class='page-link' href='$_SERVER[SCRIPT_NAME]?iddp=$valdp&date=$valdate&p=$next_page'>></a>
                            </li>";
                        }
                        elseif(empty($_GET['iddp']) && !empty($_GET['date']) && !empty($strKeyword)){
                            echo "
                            <li class='page-item'>
                            <a tabindex='-1' class='page-link' href='$_SERVER[SCRIPT_NAME]?s=$strKeyword&date=$valdate&p=$next_page'>></a>
                            </li>";
                        }
                        elseif(!empty($_GET['iddp']) && empty($_GET['date']) && !empty($strKeyword)){
                            echo "
                            <li class='page-item'>
                            <a tabindex='-1' class='page-link' href='$_SERVER[SCRIPT_NAME]?s=$strKeyword&iddp=$valdp&date=$valdate'>></a>
                            </li>";
                        }
                        elseif(!empty($_GET['iddp']) && !empty($_GET['date']) && !empty($strKeyword)){
                            echo "
                            <li class='page-item'>
                            <a tabindex='-1' class='page-link' href='$_SERVER[SCRIPT_NAME]?s=$strKeyword&iddp=$valdp'>></a>
                            </li>";
                        }
                        else{
                            echo "
                            <li class='page-item'>
                            <a tabindex='-1' class='page-link' href='$_SERVER[SCRIPT_NAME]?p=$next_page'>></a>
                            </li>";
                        }

                    }
                    $con = null;
                    ?>
                    
                </ul>
                </nav>
            <?php } ?>

				</div>	
			</div>

			<!-- Footer-->
			<?php require('structure/footer.php'); ?>



		</div>
		
	</div>

<!-- Script-->
<?php require('structure/script.php'); ?>

</body>
</html>


<!-- Modal Login -->
<div class="modal fade" id="login" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h3> ล็อกอินเข้าสู่ผู้ดูแลระบบ</h3>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
      </div>

      <div class="modal-body">
      
            <form action="sql/index/checklogin.php" method="post">
              <div class="mb-3">
                  <label class="form-label" for="username">ผู้ใช้</label>
                  <input class="form-control" type="text" name="username"  placeholder="ชื่อผู้ใช้" required>
              </div>
              <div class="mb-3">
                  <label class="form-label" for="password">รหัสผ่าน</label>
                  <input class="form-control" type="password" name="password" placeholder="รหัสผ่าน" required>
              </div>
              <div class="text-center">
                  <button class="btn btn-primary" type="submit" name="submit" id="submit" >เข้าสู่ระบบ</button>
              </div> 
          </form>
      </div>

      </div>
    </div>
  </div>
</div>

<!-- Script Link Show User-->  
<script>
function UserRow(id){
    window.location.href='download.php?id=' + id;
      }
</script>

<?php if(isset($_SESSION['msg_a'])){ ?>
    <script>	
        swal("พบข้อผิดพลาด!", "<?=$_SESSION['msg_a']?>", {
            icon : "error",
            buttons: {
                confirm: {
                    text: "ตกลง",
                    className : 'btn btn-danger'
                }
            },
            }).then(function() {
            <?php unset($_SESSION['msg_a']) ?>
           /* location.reload();*/
        });
    </script>
    <?php }; ?>