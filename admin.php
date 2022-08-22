
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

?>

</head>
<body>


<!-- Nav -->
<?php require('structure/nav.php'); ?>


		<!-- Sidebar -->
		<div class="sidebar sidebar-style-2">			
			<div class="sidebar-wrapper scrollbar scrollbar-inner">
						<div class="sidebar-content">

							<ul class="nav nav-primary">
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

							</ul>



						</div>
			</div>
		</div>
		<!-- End Sidebar -->

		<div class="main-panel">
			<div class="content">
				<div class="panel-header bg-primary-gradient">
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
          
        <!-- Card -->
        <div class="row">
            <div class="col-sm-6 col-md-4 d-none d-xl-block">
                <div class="card card-stats card-primary card-round">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-5">
                            <div class="icon-big text-center">
                                <i class="flaticon-settings"></i>
                            </div>
                            </div>
                            <div class="col-7 col-stats">
                            <div class="numbers">
                                <p class="card-category">โครงการ</p>
                                <h4 class="card-title" id="all_project"></h4>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-4 d-none d-xl-block">
                <div class="card card-stats card-primary card-round">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-5">
                            <div class="icon-big text-center">
                                <i class="flaticon-users"></i>
                            </div>
                            </div>
                            <div class="col-7 col-stats">
                            <div class="numbers">
                                <p class="card-category">เกียรติบัตร</p>
                                <h4 class="card-title" id="all_user"></h4>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-4 d-none d-xl-block">
                <div class="card card-stats card-primary card-round">
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-5">
                            <div class="icon-big text-center">
                                <i class="flaticon-success"></i>
                            </div>
                            </div>
                            <div class="col-7 col-stats">
                            <div class="numbers">
                                <p class="card-category">ผู้ดแลระบบ</p>
                                <h4 class="card-title" id="all_admin"></h4>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>        

					<div class="card">
						<h2 class="card-header"> <b>ตั้งค่าโครงการ/กิจกรรม</b>
                        <div class="float-right text-white">
                        <button class="btn btn-sm bg-primary text-white" data-toggle="modal" data-target="#AddPj" >  <i class="fas fa-plus pe-1"></i> เพิ่ม</dutton> 
                         </div>
                         </h2>
						<div class="card-body">
              
							<table id="loadproject" class="table nowrap" style="width:100%">
									<thead class="table-light">
										<tr>
											<th>ลำดับที่</th>
                      <th>สถานะ</th>
											<th>โครงการ</th>
											<th>กลุ่ม/งาน</th>
											<th>วันที่</th>
											<th>ดำเนินการ</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td> </td>
                      <td> </td>
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


			<!-- Footer-->
			<?php require('structure/footer.php'); ?>



		</div>
		
	</div>

<!-- Script-->
<?php require('structure/script.php'); ?>


  <!-- Modal Add Project -->
  <div class="modal fade" id="AddPj" tabindex="-1">
    <div class="modal-dialog ">
      <div class="modal-content ">
        <div class="modal-header">
          <h3> เพิ่มโครงการ/กิจกรรม </h3> 
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">

              <form action="sql/admin/createproject.php" method="post">
                <div class="mb-3">
                    <label class="form-label" for="name">ชื่อโครงการ/กิจกรรม</label>
                    <input class="form-control" type="text" name="name"  placeholder="โครงการ/กิจกรรม" required>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="date">วันที่</label>
                    <input class="form-control" type="date" name="date" required>
                    <small>กรุณากรอกเป็น ค.ศ. ระบบจะแปลงเป็น พ.ศ. ให้อัตโนมัติ</small>
                </div>

                <div class="mb-3">
                  <label for="type" class="form-label">รูปแบบ</label>
                    <select class="form-control" name="type">
                      <option value="0" selected>ชื่อ-นามสกุล เท่านั้น</option>
                      <option value="1">ชื่อ-นามสกุล และเพิ่มอีก 1 บรรทัด</option>
                      <option value="2">ชื่อ-นามสกุล และเพิ่มอีก 2 บรรทัด</option>
                    </select>
                  </div>

                  <?php if($_SESSION['username'] == "admin"){
                     $sql_dp = "SELECT * FROM `dp`";
                     $query_dp = mysqli_query($con, $sql_dp);
                     if (false === $query_dp) {
                         die(mysqli_error($con));
                     }
                  ?>
                  <div class="mb-3">
                      <label for="iddp" class="form-label">กลุ่ม/งาน</label>
                      <select name="iddp" id="iddp" class="form-control">	
                      <option value=""  selected value="">กรุณาเลือกกลุ่ม/งาน</option>
                        <?php foreach ($query_dp as $value_dp) { ?>
                        	<option <?php echo $value_dp['id'] == '1' ? ' selected ' : '';?> value="<?=$value_dp['id']?>"><?=$value_dp['name']?></option>
                        <?php } ?>
                      </select>	
                  </div>
                  <?php } ?>

                <div class="text-center">
                    <button class="btn btn-primary" type="submit" name="submit" class="btn"> <i class="fas fa-save"></i> บันทึก</button>
                </div> 
            </form>

          </div>
        </div>
      </div>
    </div>
  </div> 
</div>


<!-- Modal Delete -->
<div class="modal fade" id="DeletePj" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">คุณกำลังจะลบโครงการ/กิจกรรม ?</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
            </button>
      </div>
          <div class="modal-body text-center">
          <form>
            <i class="mt-2 mb-2 fas fa-exclamation-circle fa-8x text-danger"></i>

            <h3 class="mt-3">คุณแน่ใจไหมที่จะลบโครงการ/กิจกรรม</h3>
            <h4 class="mt-1">ระบบจะลบผู้เข้าร่วมในโครงการ/กิจกรรมนี้ทั้งหมด</h4>

          </div>
          <div class="mb-4 mt-3 text-center"> 
          <input type="hidden" id="id-d">

            <button type="button" onclick="DeletePj()" class="btn btn-danger"><i class="far fa-trash-alt"></i> ลบ</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-ban"></i> ยกเลิก</button>

            </form>
          </div>
    </div>
  </div>
</div>

</body>
</html>


  <!-- Modal Edit Project-->
  <div class="modal fade" id="EditPj" tabindex="-1">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
              <h3 class="modal-title">แก้ไขโครงการ/กิจกรรม</h3>
             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
            </button>
            </div>
              <div class="modal-body">
                <form>
                  <div class="mb-3">
                      <label for="name" class="form-label">ชื่อโครงการ</label>
                      <input type="text" class="form-control" id="name">
                  </div>
                  
                  <div class="mb-3">
                      <label for="date" class="form-label">วันที่</label>
                      <input type="date" class="form-control" id="date">
                      <div class="form-text">กรุณากรอกเป็น ค.ศ. ระบบจะแปลงเป็น พ.ศ. ให้อัตโนมัติ</div>
                  </div>

                  <div class="mb-3">
                  <label for="type" class="form-label">รูปแบบ</label>
                    <select class="form-control" id="type">
                      <option value="0" selected>ชื่อ-นามสกุล เท่านั้น</option>
                      <option value="1">ชื่อ-นามสกุล และเพิ่มอีก 1 บรรทัด</option>
                      <option value="2">ชื่อ-นามสกุล และเพิ่มอีก 2 บรรทัด</option>
                    </select>
                  </div>

                  <?php if($_SESSION['username'] == "admin"){
                     $sql_dp = "SELECT * FROM `dp`";
                     $query_dp = mysqli_query($con, $sql_dp);
                     if (false === $query_dp) {
                         die(mysqli_error($con));
                     }
                  ?>
                  <div class="mb-3">
                      <label for="iddp_e" class="form-label">กลุ่ม/งาน</label>
                      <select name="iddp_e" id="iddp_e" class="form-control">	
                      <option value=""  selected value="">กรุณาเลือกกลุ่ม/งาน</option>
                        <?php foreach ($query_dp as $value_dp) { ?>
                        	<option value="<?=$value_dp['id']?>"><?=$value_dp['name']?></option>
                        <?php } ?>
                      </select>	
                  </div>
                  <?php } ?>

                  <input type="hidden" id="id-e">
                  <div class="text-center">
                <button type="button" onclick="EditPj()" class="btn btn-primary"> <i class="fas fa-save"></i> แก้ไข</button>
                </form>
              </div>
    
              </div>
            </div>
          </div>
</div>



<!-- Modal Add Project -->
<div class="modal fade" id="AddUser" tabindex="-1">
    <div class="modal-dialog ">
      <div class="modal-content ">
        <div class="modal-header">
          <h5> เพิ่มผู้เข้าร่วมโครงการ/กิจกรรม </h5> 
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">

              <form action="admineditpj_createuser.php" method="post">
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
                    <button class="btn btn-primary" type="submit" name="submit" class="btn"> <i class="fas fa-save"></i> บันทึก</button>
                </div> 
            </form>

          </div>
        </div>
      </div>
    </div>
  </div> 

<script>	
$(document).ready(function () {
setInterval(function(){
  $.ajax({
      type:'POST',
      url:'sql/admin/ajax_count.php',
      data : {function:'user'},
      dataType : 'json',
      success:function(html){
          $('#all_user').html(html);
      }
  });

  $.ajax({
      type:'POST',
      url:'sql/admin/ajax_count.php',
      data : {function:'project'},
      dataType : 'json',
      success:function(html){
          $('#all_project').html(html);
      }
  });

  $.ajax({
      type:'POST',
      url:'sql/admin/ajax_count.php',
      data : {function:'admin'},
      dataType : 'json',
      success:function(html){
          $('#all_admin').html(html);
      }
  });
}, 1000);

});


</script>	

<!-- Script DataTable-->  
<script >
$(document).ready(function() {
  
  var table = $('#loadproject').DataTable( {
        //"processing": true,
        "serverSide": true,
        "ajax": "sql/admin/loadproject.php?iddp=<?=$iddp_data?>",
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
        "order": [[ 0, "desc" ]],
        "columns": [
        { "width": "7%" },
        { "width": "5%" },
        { "width": "35%" },
        { "width": "30%" },
        { "width": "15%" },
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




<!-- Script DataTable - DeletePj Button -->
<script>
  $('#DeletePj').on('shown.bs.modal', function (event) {

    var button = $(event.relatedTarget);
    var id = button.data('whatever');
    var modal = $(this);

    $('#id-d').val(id);
})

function DeletePj(){
    var id = $('#id-d').val();

        $.ajax({
            url:'sql/admin/deleteproject.php',
            method: 'POST',
            data: {id:id},
            success:function(data){
              $('#DeletePj').modal('toggle');
              swal("สำเร็จ!", "ลบโครงการ/กิจกรรมสำเร็จ [SUCCESS]", {
              icon : "success",
              buttons: {
                confirm: {
                  text: "ตกลง",
                  className : 'btn btn-success'
                }
              },
              }).then(function() {
              $('#loadproject').DataTable().draw();
              
            });
            }
          })
  }
</script>


<!-- Script DataTable - EditPj Button -->
<script>
  $('#EditPj').on('shown.bs.modal', function (event) {

    var button = $(event.relatedTarget);
    var id = button.data('whatever');
    var modal = $(this);

    $('#id-e').val(id);

    $.ajax({
        url:'sql/admin/insertproject.php',
        method: 'POST',
        data: {id:id},
        success:function(data){
          var json = $.parseJSON(data);
          $("#name").val(json[0].name);
          $("#date").val(json[0].date);
          $("#type").val(json[0].type);
          $("#iddp_e").val(json[0].iddp);
        }
      })
})

function EditPj(){
    var id = $('#id-e').val();
    var name = $('#name').val();
    var date = $('#date').val();
    var type = $('#type').val();
    if($('#iddp_e').val() != ''){
    var iddp_e = $('#iddp_e').val();
    }else{
      var iddp_e = '';
    }
        $.ajax({
            url:'sql/admin/editproject.php',
            method: 'POST',
            data: {id:id,name:name,date:date,type:type,iddp:iddp_e},
            success:function(data){
            $('#EditPj').modal('toggle');
            swal("สำเร็จ!", "แก้ไขโครงการ/กิจกรรมสำเร็จ [SUCCESS]", {
            icon : "success",
            buttons: {
              confirm: {
                text: "ตกลง",
                className : 'btn btn-success'
              }
            },
            }).then(function() {
            $('#loadproject').DataTable().draw();

          });
        
                  }
          })    
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
		//
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
		//
	});
</script>	
<?php }; ?>


