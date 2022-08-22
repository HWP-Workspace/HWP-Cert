<?php
	if(isset($_SESSION['username'])){
	$username = $_SESSION['username'];
	
	
	//รับ Name
	$sql_name = "SELECT `name` FROM `admin` WHERE `username` = '$username' ";
	$result_name  = mysqli_query($con,$sql_name ); 
	
		if (false === $result_name) {
		die(mysqli_error($con));
		}
	
			while ($row_name = mysqli_fetch_assoc($result_name)) {
				$name_data = $row_name['name'];
					break;
		}

	//รับ iddp
	$sql_iddp = "SELECT `iddp` FROM `admin` WHERE `username` = '$username' ";
	$result_iddp  = mysqli_query($con,$sql_iddp ); 
	
		if (false === $result_iddp) {
		die(mysqli_error($con));
		}

		while ($row_iddp = mysqli_fetch_assoc($result_iddp)) {
			$iddp_data = $row_iddp['iddp'];
				break;
	}

	//รับ shortdp
	$sql_sdp = "SELECT `shortdp` FROM `dp` WHERE `id` = '$iddp_data' ";
	$result_sdp  = mysqli_query($con,$sql_sdp ); 
	
		if (false === $result_sdp) {
		die(mysqli_error($con));
		}	
	
			while ($row_sdp = mysqli_fetch_assoc($result_sdp)) {
				$sdp_data = $row_sdp['shortdp'];
					break;
		}
	
	
}
?>

<div class="wrapper">
		<div class="main-header">
			<!-- Logo Header -->
			<div class="logo-header" data-background-color="purple">
				
				<a href="index.php" class="logo">
				<!--	<img src="img/logo-nav.png" alt="navbar brand" class="navbar-brand" > -->
				</a>
				<button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse" data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon">
						<i class="icon-menu"></i>
						
					</span>
				</button>

			<?php 
			if (isset($_SESSION['username']) ) {
			?>
			<button class="topbar-toggler more"><i class="icon-options-vertical"></i></button> <?php } ?>

							<div class="nav-toggle">
								<button class="btn btn-toggle toggle-sidebar">
									<i class="icon-menu"></i>
								</button>
							</div>
						</div>
						<!-- End Logo Header -->

						<!-- Navbar Header -->
						<nav class="navbar navbar-header navbar-expand-lg" data-background-color="purple2">

			<?php 
			
			if (isset($_SESSION['username']) ) {
			?>

							<div class="container-fluid">
							
								<ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
									<li class="nav-item dropdown hidden-caret">
										<a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false">
											<div class="avatar-sm">
											<img src="img/avatar-default.png" alt="profile" class="avatar-img rounded-circle">
											</div>
										</a>
										<ul class="dropdown-menu dropdown-user animated fadeIn">
											<div class="dropdown-user-scroll scrollbar-outer">
												<li>
													<div class="user-box">
														<div class="avatar-lg"><img src="img/avatar-default.png" alt="profile" class="avatar-img rounded-circle"></div>
													
														<div class="u-text">
															<h6 class="mb-0 pt-2"><?php echo $name_data ?></h6>
															<small class="text-muted mt-0 mb-0"><?php echo $sdp_data ?></small>
															
														</div>
													</div>
												</li>
												<li>
												
													<div class="dropdown-divider"></div>
													<a class="dropdown-item text-center" href="logout.php"> <h6 class="mb-0" ><i class="fas fa-power-off text-danger"></i> ออกจากระบบ</h6> </a>
												</li>
											</div>
										</ul>
									</li>
								</ul>
							</div>
						</nav>
						<!-- End Navbar -->

			<?php } ?>


		</div>