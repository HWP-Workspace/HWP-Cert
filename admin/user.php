
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

                <li class="nav-item">
									<a href="admin.php">
										<i class="fas fa-trophy"></i>
										<p>โครงการ/กิจกรรม</p>
									</a>
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
												<a href="admin_dp.php">
													<span class="sub-item">ตั้งค่ากลุ่ม/งาน</span>
												</a>
											</li>

											<li>
												<a href="">
													<span class="sub-item">ตั้งค่าผู้ดูแลระบบ</span>
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

					<div class="card">
						<h2 class="card-header"> <b>ตั้งค่าผู้ดูแลระบบ</b>
                        <div class="float-right text-white">
                        <button class="btn btn-sm bg-primary text-white" data-toggle="modal" data-target="#AddUser" >  <i class="fas fa-plus pe-1"></i> เพิ่ม</dutton> 
                         </div>
                         </h2>
						<div class="card-body">


							<table id="loaduser" class="table nowrap" style="width:100%">
									<thead class="table-light">
										<tr>
											<th>ลำดับที่</th>
											<th>ชื่อ-นามสกุล</th>
                                            <th>ชื่อผู้ใช้</th>
											<th>กลุ่ม/งาน</th>
											<th>ชื่อย่อ</th>
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
<?php
 $sql_dp = "SELECT * FROM `dp`";
 $query_dp = mysqli_query($con, $sql_dp);
 if (false === $query_dp) {
     die(mysqli_error($con));
 }
?>

 <!-- Modal Add User -->
 <div class="modal fade" id="AddUser" tabindex="-1">
    <div class="modal-dialog ">
      <div class="modal-content ">
        <div class="modal-header">
          <h3> เพิ่มผู้ดูแลระบบ </h3> 
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
            	</button>
        </div>
        <div class="modal-body">

              <form action="sql/admin/adduser.php" method="post">
                <div class="mb-3">
                    <label class="form-label" for="username">ชื่อผู้ใช้</label>
                    <input class="form-control" type="text" name="username"  placeholder="ชื่อผู้ใช้" minlength="5" required>
                    <div class="form-text">ชื่อผู้ใช้ไม่สามารถซ้ำกันได้</div>
                </div>

                <div class="mb-3">
                      <label for="password" class="form-label">รหัสผ่าน</label>
                      <input type="password" class="form-control" name="password_1" placeholder="รหัสผ่าน" minlength="8" required> 
                      <div class="form-text"></div>
                  </div>
                  <div class="mb-3">
                      <label for="password" class="form-label">ยีนยันรหัสผ่าน</label>
                      <input type="password" class="form-control" name="password_2" placeholder="ยีนยันรหัสผ่าน" minlength="8" required>
                      <div class="form-text"></div>
                  </div>

                  <div class="mb-3">
                      <label for="name" class="form-label">ชื่อผู้ดูแล</label>
                      <input type="text" class="form-control" name="name" placeholder="ชื่อผู้ดูแล" required>
                  </div>
                  
                  <div class="mb-3">
                      <label for="iddp" class="form-label">กลุ่ม/งาน</label>
                      <select name="iddp" id="iddp" class="form-control">	
                      <option value=""  selected value="">กรุณาเลือกกลุ่ม/งาน</option>
                        <?php foreach ($query_dp as $value_dp) { ?>
                        	<option value="<?=$value_dp['id']?>"><?=$value_dp['name']?></option>
                        <?php } ?>
                      </select>	
                  </div>

                <div class="text-center">
                    <button class="btn btn-primary" type="submit" name="reg_user" class="btn"> <i class="fas fa-save"></i> บันทึก</button>
                </div> 
            </form>

          </div>
        </div>
      </div>
</div>


<!-- Modal Delete -->
<div class="modal fade" id="DeleteUser" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">คุณกำลังจะลบผู้ใช้งาน ?</h3>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
            	</button>
      </div>
          <div class="modal-body text-center">
          <form>
            <i class="mt-2 mb-2 fas fa-exclamation-circle fa-8x text-danger"></i>

            <h3 class="mt-3">คุณแน่ใจไหมที่จะลบผู้ใช้งาน</h3>
            <h4 class="mt-1">หากกลบแล้วผู้ใช้งานจะไม่สามารถเข้าสู่ระบบได้</h4>

          </div>
          <div class="mb-4 mt-3 text-center"> 
          <input type="hidden" id="id-d">
            <button type="button" onclick="DeleteUser()" class="btn btn-danger"><i class="far fa-trash-alt"></i> ลบ</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-ban"></i>  ยกเลิก</button>
            </form>
      </div>
    </div>
  </div>
</div>


  <!-- Modal Edit Project-->
  <div class="modal fade" id="EditUser" tabindex="-1">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h3>แก้ไขข้อมูลผู้ดูแลระบบ</h3>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
            	</button>
              </div>
              <div class="modal-body">
                <form>
                  <div class="mb-3">
                      <label for="name" class="form-label">ชื่อผู้ใช้</label>
                      <input type="text" class="form-control" id="username" disabled>
                      <div class="form-text">ชื่อผู้ใช้ไม่สามารถซ้ำกันได้</div>
                  </div>

                  <div class="mb-3">
                      <label for="name" class="form-label">ชื่อผู้ดูแล</label>
                      <input type="text" class="form-control" id="name" required>
                  </div>
                  
                  <div class="mb-3">
                      <label for="iddp-e" class="form-label">กลุ่ม/งาน</label>
                      <select name="iddp-e" id="iddp-e" class="form-control">	
                      <option value=""  selected value="">กรุณาเลือกกลุ่ม/งาน</option>
                        <?php foreach ($query_dp as $value_dp) { ?>
                        	<option value="<?=$value_dp['id']?>"><?=$value_dp['name']?></option>
                        <?php } ?>
                      </select>		
                  </div>

                  <hr>
                  <div class="mb-3">
                      <label for="name" class="form-label">รหัสผ่าน (ถ้าต้องการแก้ไข)</label>
                      <input type="password" class="form-control" id="password" minlength="8">
                  </div>

                  <input type="hidden" id="id">
                  <div class="text-center">
                <button type="button" onclick="EditUser()" class="btn btn-primary"> <i class="fas fa-save"></i> แก้ไข</button>
                </form>
              </div>
              </div>
            </div>
          </div>
</div>


<!-- Script DataTable-->  
<script >
$(document).ready(function() {
  
  var table = $('#loaduser').DataTable( {
       // "processing": true,
        "serverSide": true,
        "ajax": "sql/admin/loaduser.php",
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
        "order": [[ 0, "asc" ]],
        "columns": [
        { "width": "7%" },
        { "width": "30%" },
        { "width": "13%" },
        { "width": "33%" },
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


<!-- Script DataTable - DeleteUser Button -->
<script>
  $('#DeleteUser').on('shown.bs.modal', function (event) {

    var button = $(event.relatedTarget);
    var id = button.data('whatever');
    var modal = $(this);

    $('#id-d').val(id);
})

function DeleteUser(){
    var id = $('#id-d').val();

        $.ajax({
            url:'sql/admin/deleteuser.php',
            method: 'POST',
            data: {id:id},
            success:function(data){
              $('#DeleteUser').modal('toggle');
			  swal("สำเร็จ!", "ลบข้อมูลผู้เข้าร่วมสำเร็จ [SUCCESS]", {
				icon : "success",
				buttons: {
				confirm: {
					text: "ตกลง",
					className : 'btn btn-success'
				}
				},
				}).then(function() {
				$('#loaduser').DataTable().draw();

			});

            }
          })
  }
</script>


<!-- Script DataTable - EditUser Button -->
<script>
$('#EditUser').on('shown.bs.modal', function (event) {

      var button = $(event.relatedTarget) 
      var id = button.data('whatever') 
      var modal = $(this)

      $('#id').val(id);

      $.ajax({
          url:'sql/admin/insertuser.php',
          method: 'POST',
          data: {id:id},
          success:function(data){
            var json = $.parseJSON(data);
            $("#username").val(json[0].username);
            $("#name").val(json[0].name);
            $("#iddp-e").val(json[0].iddp);
          }
        })
})


function EditUser(){
    var id = $('#id').val();
    var name = $('#name').val();
    var username = $('#username').val();
    var password = $('#password').val();
    var iddp = $('#iddp-e').val();

        $.ajax({
            url:'sql/admin/edituser.php',
            method: 'POST',
            data: {id:id,username:username,password:password,name:name,iddp:iddp},
            success:function(data){
			  $('#EditUser').modal('toggle');
			  swal("สำเร็จ!", "แก้ไขผู้ดูแลระบบสำเร็จ [SUCCESS]", {
				icon : "success",
				buttons: {
				confirm: {
					text: "ตกลง",
					className : 'btn btn-success'
				}
				},
				}).then(function() {
				$('#loaduser').DataTable().draw();

			});

            }
          })
}
</script>
