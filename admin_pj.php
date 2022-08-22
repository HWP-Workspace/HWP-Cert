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
}else{
  $username = $_SESSION['username'];
}

if(!isset($_GET['id'])){
	header('location: admin.php');
}

//ดึงกลุ่มสาระจากผู้ใช้งาน
if(isset($_SESSION['username'])){
  $sql_dp_user = "SELECT `iddp` FROM `admin` WHERE `username` = '$username' ";
  $result_dp_user = mysqli_query($con,$sql_dp_user); 

  if (false === $result_dp_user) {
    die(mysqli_error($con));
  }

      while ($row_dp_user = mysqli_fetch_assoc($result_dp_user)) {
                 $dp_user_data = $row_dp_user['iddp'];
                 break;
        }
}

//ดึงกลุ่มสาระจากโปรเจค
if(isset($_GET['id'])){
  $id = mysqli_real_escape_string($con, $_GET['id']);
  $sql_dp_pj = "SELECT `iddp` FROM `project` WHERE `id` = '$id' ";
  $result_dp_pj = mysqli_query($con,$sql_dp_pj); 

  if (false === $result_dp_pj) {
    die(mysqli_error($con));
  }

      while ($row_dp_pj = mysqli_fetch_assoc($result_dp_pj)) {
                 $dp_pj_data = $row_dp_pj['iddp'];
                 break;
        }
}

//รับชื่อโครงการ
if(isset($_GET['id'])){
    $id = mysqli_real_escape_string($con, $_GET['id']);
    $sql_namepj = "SELECT `name` FROM `project` WHERE `id` = '$id' ";
    $result_namepj = mysqli_query($con,$sql_namepj); 

    if (false === $result_namepj) {
      die(mysqli_error($con));
    }

        while ($row_name = mysqli_fetch_assoc($result_namepj)) {
                   $namepj_data = $row_name['name'];
                   break;
          }
}

//รับ Tempate Img
if(isset($_GET['id'])){
	$id = mysqli_real_escape_string($con, $_GET['id']);
	$sql_img = "SELECT `tempate` FROM `project` WHERE `id` = '$id' ";
	$result_img  = mysqli_query($con,$sql_img ); 
  
	if (false === $result_img) {
	  die(mysqli_error($con));
	}
  
		while ($row_img = mysqli_fetch_assoc($result_img)) {
				   $img_data = $row_img['tempate'];
				   break;
	}
  }
  
  //เช็คในฐานข้อมูล user ว่า เป็นค่าว่างไหม
  if(isset($_GET['id'])){
	$id = mysqli_real_escape_string($con, $_GET['id']);
	$check_user = "SELECT * FROM `user` WHERE `idpj` =".$id;
	$result_user  = mysqli_query($con, $check_user);
  
	if (false === $result_user) {
	  die(mysqli_error($con));
	}
  
	$num_user = mysqli_num_rows($result_user); 
  }
  
  //รับค่า Type
  if(isset($_GET['id'])){
  $id = mysqli_real_escape_string($con, $_GET['id']);
  $query_type = "SELECT `type` FROM `project` WHERE `id` =".$id; 
  $result_type = mysqli_query($con,$query_type); 
  
  if (false === $result_type) {
	die(mysqli_error($con));
  }
  
  while ($row_type = mysqli_fetch_assoc($result_type)) {
			 $type_data = $row_type['type'];
			 break;
  }
}



if($namepj_data == '' || $namepj_data == null){ // เช็คค่าว่างหากไอดีไม่ถูกต้อง
  header('location: admin.php');
}elseif($dp_pj_data != $dp_user_data && $dp_user_data != '1'){ // เช็คหากโครงการ ไม่ตรงกับ ผู้ใช้งาน
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
									<a href="index.php">
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
									<a href="admin.php">
										<i class="fas fa-arrow-left"></i>
										<p>ย้อนกลับ</p>
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



    <div class="row">
      <div class="col-12">
        <div class="card">
            <div class="card-body text-center">
              <h2><b>โครงการ : <?=$namepj_data?></b></h2>
            </div>
          </div>
    </div>

      <div class="col-xl-4 col-12">
          <div class="card">
						<h3 class="card-header"> <b>ตั้งค่ารูปแบบโครงการ</b></h3>
						<div class="card-body">

            <?php
            $sql = "SELECT * FROM project WHERE id = '$id'";
            $result = mysqli_query($con, $sql);

            if (false === $result) {
              die(mysqli_error($con));
            }

            while($row = mysqli_fetch_assoc($result)){
            $color_sql = $row['color'];
            ?>

              <div class="form-group mb-3">
                <label for="font">ฟอนต์</label>
                <select class="form-control" id="font" name="font" required>
                  <option <?php echo $row['font'] == 'thniramitas' ? ' selected ' : '';?> value="thniramitas">TH Niramit AS</option>
                  <option <?php echo $row['font'] == 'thsarabunnew' ? ' selected ' : '';?> value="thsarabunnew">TH Sarabun New (ค่าเริ่มต้น)</option>
                </select>
              </div>

              <div class="form-group range-wrap mb-5">
                <label for="margin">ระยะขอบ <small class="text-danger">[px]</small></label>
                <input type="range" class="form-control-range range" value="<?=$row['margin']?>" min="0" max="1000" name="margin" id="margin" required>
                <output class="bubble"></output>
              </div>

              <div class="form-group mb-3">
                <label for="color">สีฟอนต์</label>
                <input type="text" class="form-control" name="color" id="color" required>
              </div>

              <div class="form-group range-wrap mb-5">
                <label for="size_name">ขนาดฟอนต์ (บรรทัดที่ 1) <small class="text-danger">[px]</small></label>
                <input type="range" class="form-control-range range" value="<?=$row['size_name']?>" min="0" max="144" name="size_name" id="size_name" required>
                <output class="bubble"></output>
              </div>

              <?php if($type_data == 1){ ?>
              <div class="form-group range-wrap mb-5">
                <label for="size_line2">ขนาดฟอนต์ (บรรทัดที่ 2) <small class="text-danger">[px]</small></label>
                <input type="range" class="form-control-range range" value="<?=$row['size_line2']?>" min="0" max="144" name="size_line2" id="size_line2" required>
                <output class="bubble"></output>
              </div>
              <?php } if($type_data == 2){?>
                <div class="form-group range-wrap mb-5">
                <label for="size_line2">ขนาดฟอนต์ (บรรทัดที่ 2) <small class="text-danger">[px]</small></label>
                <input type="range" class="form-control-range range" value="<?=$row['size_line2']?>" min="0" max="144" name="size_line2" id="size_line2" required>
                <output class="bubble"></output>
              </div>
              <div class="form-group range-wrap mb-5">
                <label for="size_line3">ขนาดฟอนต์ (บรรทัดที่ 3) <small class="text-danger">[px]</small></label>
                <input type="range" class="form-control-range range" value="<?=$row['size_line3']?>" min="0" max="144" name="size_line3" id="size_line3" required>
                <output class="bubble"></output>
              </div>
                <?php } ?>
              <div class="text-center">
                <button class="btn btn-primary btn-sm" type="button" onclick="EditCer()"> <i class="fas fa-save"></i> บันทึก</button>
              </div>

              <?php } ?>


						</div>
					</div>
        </div>

      <div class="col-xl-8 col-12">
					<div class="card">
						<h3 class="card-header"> <b>ตั้งค่าโครงการ</b>
                        <div class="float-right text-white mt-3 mt-md-0">
            <button class="btn btn-sm bg-primary text-white" data-toggle="modal" data-target="#AddL" >  <i class="fas fa-plus pe-1"></i> เพิ่ม</dutton> 
						<button class="btn btn-sm bg-info text-white ml-2" data-toggle="modal" data-target="#AddUP" >  <i class="fas fa-file-upload"></i> อัปโหลด</dutton>	
						<button class="btn btn-sm bg-success text-white ml-2" data-toggle="modal" data-target="#AddUE" >  <i class="fas fa-plus"></i> นำเข้า</dutton>
						<form action="sql/admin/deletelearnall.php" method="post">
						<?php if($num_user > 0) { 
										echo " 
										<input type=\"hidden\" name=\"id\" value=\"$id\">
										<button type=\"submit\" class=\"btn btn-sm bg-danger text-white pl-2 ml-2\"> <i class=\"fas fa-trash pe-1\"></i> ลบทั้งหมด</dutton>";}?>
						</form>
				
                         </div>
                         </h3>
						<div class="card-body">
							<table id="loadlearn" class="table nowrap" style="width:100%">
									<thead class="table-light">
										<tr>
											<th>ลำดับที่</th>
											<th>ชื่อ - นามสกุล</th>
											<th>รหัสเกียรติบัตร</th>
											<th>ดำเนินการ</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td> </td>
											<td> </td>
											<td> </td>
											<td> </td>
										</tr>
									</tbody>
							</table>
						</div>
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


<!-- Modal Add Project -->
<div class="modal fade" id="AddL" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content ">
        <div class="modal-header">
          <h3> เพิ่มผู้เข้าร่วมโครงการ/กิจกรรม </h3> 
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
            	</button>
        </div>
        <div class="modal-body">

              <form action="sql/admin/createlearn.php" method="post">
                <div class="mb-3">
                    <label class="form-label" for="name">ชื่อ-นามสกุล</label>
                    <input class="form-control" type="text" name="name"  placeholder="ชื่อ-นามสกุล" required>
                </div>

                <?php
                  if($type_data == 1 ){
                   echo '<div class="mb-3">
                      <label for="line2" class="form-label">บรรทัด 2</label>
                      <input type="text" class="form-control" name="line2" placeholder="บรรทัด 2">
                  </div>' ;
                  }
                  if($type_data == 2){
                  echo 
                  '<div class="mb-3">
                      <label for="line2" class="form-label">บรรทัด 2</label>
                      <input type="text" class="form-control" name="line2" placeholder="บรรทัด 2">
                      </div>

                  <div class="mb-3">
                      <label for="line3" class="form-label">บรรทัด 3</label>
                      <input type="text" class="form-control" name="line3" placeholder="บรรทัด 3">
                      </div>';
                  }
                  ?>
                <input type="hidden" name="id" value="<?=$_GET['id']?>" > 
                <div class="text-center">
                    <button class="btn btn-primary" type="submit" name="submit" > <i class="fas fa-save"></i> บันทึก</button>
                </div> 
            </form>

          </div>
        </div>
      </div>
    </div>
</div> 



  <!-- Modal Edit Learn-->
<div class="modal fade" id="EditLearn" tabindex="-1">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h3>แก้ไขผู้เข้าร่วมโครงการ/กิจกรรม</h3>
				          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
            	</button>
              </div>
              <div class="modal-body">
                <form>
                  <div class="mb-3">
                      <label for="name" class="form-label">ชื่อ-นามสกุล</label>
                      <input type="text" class="form-control" id="name">
                  </div>
                  
                  <?php
                  if($type_data == 1 ){
                   echo '<div class="mb-3">
                      <label for="name" class="form-label">บรรทัด 2</label>
                      <input type="text" class="form-control" id="line2">
                  </div>' ;
                  }
                  if($type_data == 2){
                  echo 
                  '<div class="mb-3">
                      <label for="name" class="form-label">บรรทัด 2</label>
                      <input type="text" class="form-control" id="line2">
                      </div>

                  <div class="mb-3">
                      <label for="name" class="form-label">บรรทัด 3</label>
                      <input type="text" class="form-control" id="line3">
                      </div>';
                  }
                  ?>

                  <input type="hidden" id="id">
                  <div class="text-center">
                <button type="button" onclick="EditLearn()" class="btn btn-primary"> <i class="fas fa-save"></i> แก้ไข</button>
                </form>
              </div>
    
              </div>
            </div>
          </div>
</div>


<!-- Modal Upload Excel -->
<div class="modal fade" id="AddUE" tabindex="-1">
    <div class="modal-dialog ">
      <div class="modal-content ">
        <div class="modal-header">
          <h3> นำเข้ารายชื่อ </h3> 
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
              <form action="excel/import.php" method="post" enctype="multipart/form-data">

			  <div class="mb-3">
                    <label class="form-label" for="name">กรุณาอัปโหลดไฟล์ .csv (UTF-8) หรือ .xlsx เท่านั้น</label>
                    <div class="input-group mb-3">
					<div class="input-group-prepend">
						<span class="input-group-text">อัปโหลด</span>
					</div>


					<div class="custom-file">
					<input type="file" accept=".xlsx, .csv" class="custom-file-input" name="file" id="file" required>
					<label class="custom-file-label" for="file">Choose file</label>
					</div>
                </div>

                <label class="form-label pe-3" for="name">ตัวอย่างไฟล์ </label>
                 <a class ="text-success" href="example_file/example_excel/example.csv" > <i class="fas fa-file-excel"></i> example.csv </a> 
                 <a class ="text-success ms-3" href="example_file/example_excel/example.xlsx" > <i class="fas fa-file-excel"></i> example.xlsx </a>

                 <input type="hidden" name="id" value="<?=$_GET['id']?>"> 
                <div class="text-center mt-3">
                    <button class="btn btn-primary" type="submit" id="import" name="import" > <i class="fas fa-file-import"></i> นำเข้า</button>
                </div> 
            </form>
          </div>
        </div>
      </div>
    </div>
</div>


<!-- Modal Upload Tempate -->
<div class="modal fade" id="AddUP" tabindex="-1">
      <div class="modal-dialog ">
        <div class="modal-content ">
          <div class="modal-header">
            <h3> อัปโหลดแม่แบบเกียรติบัตร </h3> 
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">

        <form action="sql/admin/uptempate.php" method="post" enctype="multipart/form-data">
				<div class="mb-3">
          <label class="form-label" for="name">กรุณาอัปโหลดไฟล์เทมเพลต .jpg, .jpeg, .png เท่านั้น</label>
          <div class="input-group mb-3">
					<div class="input-group-prepend">
						<span class="input-group-text">อัปโหลด</span>
					</div>


					<div class="custom-file">
					<input type="file" accept=".jpg, .png, .jpeg" class="custom-file-input" name="upload" id="upload" required>
					<label class="custom-file-label" for="file">Choose file</label>
					</div>
                </div>
                  
                  <?php 
                  if(!empty($img_data)){
                   echo  "<label class=\"form-label\" for=\"name\"> <div class=\"mb-2\">รูปแบบ : </div>  <img class=\"img-cert\" src=\"upload/tempate/$img_data\"></label>" ;
                  }   
                  ?>

                  <input type="hidden" name="id" value="<?=$_GET['id']?>" > 
                  <div class="text-center mt-3">
                      <button class="btn btn-primary" type="submit" name="submit" > <i class="fas fa-file-import"></i> นำเข้า</button>
                  </div> 
              </form>

			
              
            </div>
          </div>
        </div>
      </div>
</div>


<!-- Modal Delete -->
<div class="modal fade" id="DeleteLearn" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">คุณกำลังจะลบผู้เข้าร่วมโครงการ/กิจกรรม ? </h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
            </button>
      </div>
          <div class="modal-body text-center">
          <form>
            <i class="mt-2 mb-2 fas fa-exclamation-circle fa-8x text-danger"></i>

            <h3 class="mt-3">คุณแน่ใจไหมที่จะลบผู้เข้าร่วมโครงการ/กิจกรรม </h3>
            <h4 class="mt-1">หากลบแล้วการรันเลขเกียรติบัตรจะไม่ต่อเนื่องกัน</h4>

          </div>
          <div class="mb-4 mt-3 text-center"> 
          <input type="hidden" id="id">
            <button type="button" onclick="DeleteLearn()" class="btn btn-danger"><i class="far fa-trash-alt"></i> ลบ</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-ban"></i> ยกเลิก</button>
            </form>
      </div>
    </div>
  </div>
</div>


<!-- Script DataTable-->  
<script >
$(document).ready(function() {
  
  var table = $('#loadlearn').DataTable( {
        //"processing": true,
        "serverSide": true,
        "ajax": "sql/admin/loadlearn.php?id=<?php echo (isset($_GET['id']) ? $_GET['id'] : ''); ?>",
        "language" : {
              "emptyTable": "ไม่มีข้อมูลในตาราง",
              "info": "แสดง _START_ ถึง _END_ จาก _TOTAL_ แถว",
              "infoEmpty": "แสดง 0 ถึง 0 จาก 0 แถว",
              "infoFiltered": "(กรองข้อมูล _MAX_ ทุกแถว)",
              "infoThousands": ",",
              "lengthMenu": "แสดง _MENU_ แถว",
              "loadingRecords": "กำลังโหลดข้อมูล...",
              "processing": "กำลังดำเนินการ...",
              "search": "ค้นหา: ",
              "zeroRecords": "ไม่พบข้อมูล",
              "paginate": {
                  "first": "หน้าแรก",
                  "previous": "ก่อนหน้า",
                  "next": "ถัดไป",
                  "last": "หน้าสุดท้าย"
              },
              "aria": {
                  "sortAscending": ": เปิดใช้งานการเรียงข้อมูลจากน้อยไปมาก",
                  "sortDescending": ": เปิดใช้งานการเรียงข้อมูลจากมากไปน้อย"
              },
              "autoFill": {
                  "cancel": "ยกเลิก",
                  "fill": "กรอกทุกช่องด้วย",
                  "fillHorizontal": "กรอกตามแนวนอน",
                  "fillVertical": "กรอกตามแนวตั้ง",
                  "info": "ข้อมูลเพิ่มเติม"
              },
              "buttons": {
                  "collection": "ชุดข้อมูล",
                  "colvis": "การมองเห็นคอลัมน์",
                  "colvisRestore": "เรียกคืนการมองเห็น",
                  "copy": "คัดลอก",
                  "copyKeys": "กดปุ่ม Ctrl หรือ Command + C เพื่อคัดลอกข้อมูลบนตารางไปยัง Clipboard ที่เครื่องของคุณ"
              }
          },
        "order": [[ 1, "asc" ]],
        "columns": [
        { "width": "7%" },
        { "width": "53%" },
        { "width": "35%" },
        { "width": "5%" }
         ],

         responsive: true
    } );
    

    table.on('draw.dt', function () {
    var info = table.page.info();
    table.column(0, { search: 'applied', order: 'applied', page: 'applied' }).nodes().each(function (cell, i) {
        cell.innerHTML = i + 1 + info.start;
    });
    });

} );
</script>


<!-- Script DataTable - SettingPj Button -->
<script>
function SettingPj(id){
        window.location.href='admin_pj.php?id=' + id;
      }
</script>





<?php if(isset($_SESSION['msg_w'])){ ?>
<script>	
	swal("พบข้อผิดพลาด!", "<?=$_SESSION['msg_w']?>", {
		icon : "warning",
		buttons: {
			confirm: {
				text: "ตกลง",
				className : 'btn btn-warning'
			}
		},
		}).then(function() {
		<?php unset($_SESSION['msg_w']) ?>
		//location.reload();
	});
</script>	

<?php }; ?>

<?php if(isset($_SESSION['msg_s'])){ ?>
<script>	
	swal("สำเร็จ!", "<?=$_SESSION['msg_s']?>", {
		icon : "success",
		buttons: {
			confirm: {
				text: "ตกลง",
				className : 'btn btn-success'
			}
		},
		}).then(function() {
		<?php unset($_SESSION['msg_s']) ?>
		//location.reload();
	});
</script>	

<?php }; ?>

<script>
$(".custom-file-input").on("change", function() {
var fileName = $(this).val().split("\\").pop();
 $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
});
</script>


<!-- Script DataTable - EditLearn Button -->
<script>
  $('#EditLearn').on('shown.bs.modal', function (event) {

    var button = $(event.relatedTarget) 
    var id = button.data('whatever') 
    var modal = $(this)

    $('#id').val(id);

    $.ajax({
        url:'sql/admin/insertlearn.php',
        method: 'POST',
        data: {id:id},
        success:function(data){
          var json = $.parseJSON(data);
          $("#name").val(json[0].name);
          $("#line2").val(json[0].line2);
          $("#line3").val(json[0].line3);
        }
      })
})

function EditLearn(){
    var id = $('#id').val();
    var name = $('#name').val();
    var line2 = $('#line2').val();
    var line3 = $('#line3').val();
        $.ajax({
            url:'sql/admin/learnedit.php',
            method: 'POST',
            data: {id:id,name:name,line2:line2,line3:line3},
            success:function(data){
              $('#EditLearn').modal('toggle');
              swal("สำเร็จ!", "แก้ไขข้อมูลผู้เข้าร่วมสำเร็จ [SUCCESS]", {
              icon : "success",
              buttons: {
                confirm: {
                  text: "ตกลง",
                  className : 'btn btn-success'
                }
              },
              }).then(function() {
              $('#loadlearn').DataTable().draw();

            });
	
            }
          })  
  }
</script>

<!-- Script DataTable - DeleteLearn Button -->
<script>
  $('#DeleteLearn').on('shown.bs.modal', function (event) {

    var button = $(event.relatedTarget);
    var id = button.data('whatever');
    var modal = $(this);

    $('#id').val(id);
})

function DeleteLearn(){
    var id = $('#id').val();

        $.ajax({
            url:'sql/admin/deletelearn.php',
            method: 'POST',
            data: {id:id},
            success:function(data){
              $('#DeleteLearn').modal('toggle');   
            swal("สำเร็จ!", "ลบข้อมูลผู้เข้าร่วมสำเร็จ [SUCCESS]", {
            icon : "success",
            buttons: {
              confirm: {
                text: "ตกลง",
                className : 'btn btn-success'
              }
            },
            }).then(function() {
            $('#loadlearn').DataTable().draw();

          });
	
            }
          })
  }
</script>


<script>
$('#color').colorpicker({ 
    inline: false,
    container: true,
    format: 'hex'
});
$("#color").val('<?=$color_sql?>');
$("#color").trigger('change');

</script>

<script>
function EditCer (){
    var id = '<?=$_GET['id']?>';
    var font = $('#font').val();
    var margin = $('#margin').val();
    var color = $('#color').val();
    var size_name = $('#size_name').val();
    var size_line2 = $('#size_line2').val()
    var size_line3 = $('#size_line3').val();

  $.ajax({
   url:'sql/admin/editcer.php',
   method: 'POST',
   data: {id:id,font:font,margin:margin,color:color,size_name:size_name,size_line2:size_line2,size_line3:size_line3},
   success:function(data){
   swal("สำเร็จ!", "แก้ไขรูปแบบโครงการสำเร็จ [SUCCESS]", {
   icon : "success",
   buttons: {
     confirm: {
       text: "ตกลง",
       className : 'btn btn-success'}
   }
  });
  }
 })
}
</script>

<script>
$(document).ready(function() {
const allRanges = document.querySelectorAll(".range-wrap");
  allRanges.forEach(wrap => {
  const range = wrap.querySelector(".range");
  const bubble = wrap.querySelector(".bubble");

  range.addEventListener("input", () => {
    setBubble(range, bubble);
  });
  setBubble(range, bubble);
});

function setBubble(range, bubble) {
  const val = range.value;
  const min = range.min ? range.min : 0;
  const max = range.max ? range.max : 100;
  const newVal = Number(((val - min) * 100) / (max - min));
  bubble.innerHTML = val;

  // Sorta magic numbers based on size of the native UI thumb
  bubble.style.left = `calc(${newVal}% + (${8 - newVal * 0.15}px))`;
}

})
</script>