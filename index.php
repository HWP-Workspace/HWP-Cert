
<!DOCTYPE html>
<html lang="en">
<head>

<!-- Head -->
<?php 
session_start();
require('structure/head.php'); 

if(isset($_SESSION['username'])){
	header('location: admin.php');
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
									<a href="">
										<i class="fas fa-home"></i>
										<p>หน้าแรก</p>
									</a>

								</li>
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

                <?php 
                require('structure/datethai.php');

                $perpage = 8;
                if (isset($_GET['p'])) {
                $page = $_GET['p'];
                } else {
                $page = 1;
                }
                $start = ($page - 1) * $perpage;
                $query = "SELECT * FROM project ORDER BY id DESC LIMIT {$start} , {$perpage}" or die("Error:" . mysqli_error());
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

                while($row = mysqli_fetch_array($result)){ 
                if($row["tempate"] == ''){

                }else{
                    $image = ''.$url.'./upload/tempate/' .$row["tempate"].'';
                    $imageData = base64_encode(file_get_contents($image));
                    $src = 'data: ' . ';base64,' . $imageData;
                ?> 
                      
                    <div class="col-xl-3 col-xs-12 col-md-6 mb-4">   
                        <div class="card h-90">
                        <img class="card-img-top" style="pointer-events: none;" src="<?=$src?>" alt="Certificate Preview">
                        <div class="card-body">
                            <h6 class="card-title"><?=$row["name"]?></h6>
                            <small class="card-text d-block" style="opacity: 0.7;"><?=$row["dp"]?></small>
                            <small class="card-text d-block" style="opacity: 0.6;"><i class="text-primary pr-1 far fa-calendar-minus"></i><?=DateThai($row["date"])?></small>
                            
                            <div class="text-center mt-1">
                            <button onclick="UserRow(<?=$row['id']?>)" class="btn btn-sm btn-primary "><i class="fas fa-user"></i> รายชื่อ</button>
                            </div>
                        </div>
                        </div>
                    </div>                    
                <?php } } ?>
                </div>

                <?php
                $sql2 = "SELECT * FROM project ";
                $query2 = mysqli_query($con, $sql2);
                $total_record = mysqli_num_rows($query2);
                $total_page = ceil($total_record / $perpage);
                ?>

            <?php if($total_page > 1){?>                
                <div class="mt-4 row justify-content-center"> 
                    <nav>
                    <ul class="pagination">
                <?php if($page == 0){?> 
                    <li class="page-item">
                        <a class="page-link" href="index.php?p=1" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                        </a>                        
                    </li>
                <?php } ?>
                    
                    <?php for($i=1;$i<=$total_page;$i++){ ?>
                    <?php if ($i == $page){ ?>
                    <li class="page-item active" ><a class="page-link" href="index.php?p=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                    <?php }else{ ?>        
                    <li class="page-item" ><a class="page-link" href="index.php?p=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                    <?php } } ?>

                    <li class="page-item">
                    <a class="page-link" href="index.php?p=<?php echo $total_page;?>" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                    </a>
                    </li>
                    </ul>
                    </nav>  
                </div>
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