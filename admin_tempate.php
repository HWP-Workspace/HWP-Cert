
<!DOCTYPE html>
<html lang="en">
<head>

<!-- Head -->
<?php 
session_start();
if(!isset($_SESSION['username'])){
	header('location: index.php');
}

require('structure/head.php'); 
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
								<li class="nav-item">
									<a href="admin.php">
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
												<a href="admin_user.php">
													<span class="sub-item">รายชื่อผู้ดูแลระบบ</span>
												</a>
											</li>
          

											</li>
										</ul>
									</div>
								</li>
 							 <?php } ?>

                                 <li class="nav-item active">
									<a href="" >
										<i class="fas fa-file"></i>
										<p>เทมเพลต</p>
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

					<div class="card">
						<h2 class="card-header"> <b>ไฟล์เทมเพลตเกียรติบัตร (.psd)</b></h2>
						<div class="card-body">


                        <div class="text-center">
                            <img class= "img-cert" src="img/img_excert.jpg" alt="Tempate Cert" width="390" height="290">
                        </div>
                        <div class="row text-center pt-3"> 
                        <div class="col"> <h6> ชื่อ-นามสกุล เท่านั้น </h6> <button onclick="window.location.href='example_file/example_tempate/name.psd'" type="button" class="btn btn-sm btn-primary"><i class="fas fa-file-download"></i> ดาวน์โหลด </button> </div> 
                        <div class="col"> <h6> ชื่อ-นามสกุล + 1 บรรทัด</h6> <button onclick="window.location.href='example_file/example_tempate/line2.psd'" type="button" class="btn btn-sm btn-primary"><i class="fas fa-file-download"></i> ดาวน์โหลด </button> </div> 
                        <div class="col"> <h6> ชื่อ-นามสกุล + 2 บรรทัด</h6> <button onclick="window.location.href='example_file/example_tempate/line3.psd'" type="button" class="btn btn-sm btn-primary"><i class="fas fa-file-download"></i> ดาวน์โหลด </button> </div> 
                        </div>



						</div>
					
					</div>

















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

