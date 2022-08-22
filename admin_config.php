
<!DOCTYPE html>
<html lang="en">
<head>

<!-- Head -->
<?php 
session_start();
require('connect.php');
require('structure/head.php'); 

if(!isset($_SESSION['username'])){
	header('location: index.php');
}

if($_SESSION['username'] !== "admin"){
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


                                  <li class="nav-item active">
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
						

                                    <li class="nav-item">
									<a href="admin_tempate.php" >
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
						<h2 class="card-header"> <b>ตั้งค่าโครงสร้างระบบ</b>
                         </h2>
						<div class="card-body">

						<form>
						<div class="row">

							<div class="col-xl-6 col-xs-12">
								<div class="mb-3">
								<label for="name" class="form-label">ชื่อหน่วยงาน/โรงเรียน (ภาษาไทย)<text class="text-danger"> *</text></label>
								<input type="text" class="form-control" id="name" name="name" required>
								</div>
							</div>

							<div class="col-xl-6 col-xs-12">
								<div class="mb-3">
								<label for="shortname" class="form-label">ชื่อย่อหน่วยงาน/โรงเรียน<text class="text-danger"> *</text></label>
								<input type="text" class="form-control" id="shortname" name="shortname" required>
								<small class="form-text text-muted text-danger">ไม่จำเป็นต้องใส่ . (จุด) ต่อท้าย</small>		
								</div>
							</div>
					
							<div class="col-12">
							<label>อัปโหลดตราสัญลักษณ์หน่วยงาน/โรงเรียน (.ico เท่านั้น)<text class="text-danger"> *</text></label>			
							<div class="custom-file">
							<input type="file" accept=".ico" class="custom-file-input" name="logo" id="logo" required/>
							<label class="custom-file-label" for="logo">เลือกไฟล์ .ico เท่านั้น</label>
							</div>

								<div class="text-center mt-5 col-12"> ตราสัญลักษณ์ (ปัจจุบัน) <br> <img class="mt-3" src="img/fav.ico" height="150" width="150">
								</div>  
		
						</div>


						</div>

					

						
						<div class="text-center pt-3">
                            <button type="button" onclick="EditSys()" class="btn btn-primary mt-3"><i class="fas fa-save"></i> บันทึก</button>
                        </div>
						

						</div>
					</div>
						</form>















				</div>	
			</div>


			<!-- Footer-->
			<?php require('structure/footer.php'); ?>



		</div>
		
	</div>

<!-- Script-->
<?php require('structure/script.php'); ?>

<script>
$(".custom-file-input").on("change", function() {
var fileName = $(this).val().split("\\").pop();
 $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
});
</script>

<script type="text/javascript">
$(document).ready(function() {
      $.ajax({
      type: "POST",
      url: "sql/admin/ajax_config.php",
      data: {function:'name'},
      success: function(data){
          $('#name').val(data); 
      }
    });
  });

  $(document).ready(function() {
      $.ajax({
      type: "POST",
      url: "sql/admin/ajax_config.php",
      data: {function:'shortname'},
      success: function(data){
          $('#shortname').val(data); 
      }
    });
  });



  function dn(lcat)
		{
			return document.getElementById(lcat);
		}
		function PageReload()
		{

			swal("สำเร็จ!", "แก้ไขข้อมูลระบบสำเร็จ [SUCCESS]", {
              icon : "success",
              buttons: {
                confirm: {
                  text: "ตกลง",
                  className : 'btn btn-success'
                }
              },
              }).then(function() {
				location.reload();
			})

			
		}
        function EditSys()
        {
        	var xh = new XMLHttpRequest(),
        		ob = new FormData();
        	ob.append('name',dn('name').value);
        	ob.append('shortname',dn('shortname').value);
        	ob.append('logo',dn('logo').files[0]);
        	xh.open('POST','sql/admin/editsystem.php',true);
        	xh.onreadystatechange = function()
        	{
        		if(this.readyState!==4) return;
        		if(this.status!==200) return;

        		PageReload();
        	};
        	xh.send(ob);
        }

</script>