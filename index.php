
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

					<div class="card">
						<h2 class="card-header"> <b>ตารางแสดงโครงการ/กิจกรรม</b></h2>
						<div class="card-body">

							<table id="loadproject" class="table nowrap" style="width:100%">
									<thead class="table-light">
										<tr>
											<th>ลำดับที่</th>
											<th>โครงการ</th>
											<th>กลุ่ม/งาน</th>
											<th>วันที่</th>
											<th>เกียรติบัตร</th>
										</tr>
									</thead>
									<tbody>
										<tr>
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

<!-- Script DataTable-->  
<script >
$(document).ready(function() {
  
  var table = $('#loadproject').DataTable( {
        //"processing": true,
        "serverSide": true,
        "ajax": "sql/index/loadproject.php",
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
        { "width": "40%" },
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