<?php
session_start();
require('connect.php');

//รับชื่อโครงการ
if(!empty($_GET['id'])){
  $idpj = mysqli_real_escape_string($con, $_GET['id']);
  $sql_namepj = "SELECT `name` FROM `project` WHERE `id` = '$idpj' ";
  $result_namepj = mysqli_query($con,$sql_namepj); 

  if (false === $result_namepj) {
    die(mysqli_error($con));
  }

  $num_pj = mysqli_num_rows($result_namepj); 

  if($num_pj == 0){
	header("location:index.php");
  }

	while ($row_name = mysqli_fetch_assoc($result_namepj)) {
		$namepj_data = $row_name['name'];
		break;
			}

  }
  else{
	header("location:index.php");
  }



?>

<!DOCTYPE html>
<html lang="en">
<head>

<!-- Head -->
<?php require('structure/head.php'); ?>

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
                  <i class="fas fa-arrow-left"></i>
										<p>กลับไปหน้าแรก</p>
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
						<h3 class="card-header"><b><?php echo $namepj_data ?> </b></h3>
						<div class="card-body">


                        <table id="user" class="table nowrap" style="width:100%">
                        <thead class="table-light">
                            <tr>
                                <th>ลำดับที่</th>
                                <th>ชื่อ-นามสกุล</th>
                                <th>เลขที่เกียรติบัตร</th>
                                <th>ดาวน์โหลด</th>
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
                  <button class="btn btn-primary" type="submit" name="login_user" >เข้าสู่ระบบ</button>
              </div> 
          </form>
      </div>

      </div>
    </div>
  </div>
</div>

<!-- Script DataTable - User -->
<script>
$(document).ready(function() {
    var table = $('#user').DataTable( {
        //"processing": true,
        "serverSide": true,
        "ajax": "sql/download/loaduser.php?id=<?php echo (isset($_GET['id']) ? $_GET['id'] : ''); ?>",
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
        "columns": [
        { "width": "5%" },
        { "width": "45%" },
        { "width": "40%" },
        { "width": "10%" }
         ],
         "order": [[ 1, 'asc' ]],
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

<!-- Srcript Print Cer -->
<script>
function PrintCer(id) {
  var idpj = <?= $idpj ?> ;      
  window.open('print.php?id=' + idpj  +'&'+ 'learn=' + id, '_blank')

}
</script>