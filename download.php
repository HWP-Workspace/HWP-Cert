<?php 
    session_start();
    require('connect.php');

  //รับชื่อโครงการ
if(isset($_GET['id'])){
  $idpj = mysqli_real_escape_string($con, $_GET['id']);
  $sql_namepj = "SELECT `name` FROM `project` WHERE `id` = '$idpj' ";
  $result_namepj = mysqli_query($con,$sql_namepj); 

  if (false === $result_namepj) {
    die(mysqli_error($con));
  }

  while ($row_name = mysqli_fetch_assoc($result_namepj)) {
      $namepj_data = $row_name['name'];
      break;
        }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>

<!--- Head --->
<?php require('structure/head.php'); ?>
</head>
<body>

<!--- Nav --->
<?php require('structure/nav.php'); ?>


<!--- Card Content --->
<div class="container">
  <div class="card mt-4 shadow-sm" >
    <div class="card-header text-white" id= "card-content">
      <h6 class="pt-1"><i class="fas fa-table pe-2"></i>รายชื่อผู้เข้าร่วมกิจกรรม/โครงการ : <?php echo $namepj_data ?> </h6>
    </div>
      <div class="card-body">
        <table id="user" class="table table-bordered nowrap" style="width:100%">
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

<!-- Modal Login -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <div id="exampleModalLabel"> ล็อกอินเข้าสู่ผู้ดูแลระบบ</div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

            <form action="checklogin.php" method="post">
              <div class="mb-3">
                  <label class="form-label" for="username">ผู้ใช้</label>
                  <input class="form-control" type="text" name="username"  placeholder="ชื่อผู้ใช้" required>
              </div>
              <div class="mb-3">
                  <label class="form-label" for="password">รหัสผ่าน</label>
                  <input class="form-control" type="password" name="password" placeholder="รหัสผ่าน" required>
              </div>
              <div class="text-center">
                  <button class="btn btn-primary" type="submit" name="login_user" class="btn">เข้าสู่ระบบ</button>
              </div> 
          </form>
          </div>
      </div>
    </div>
  </div>
</div>

<!--- Footer --->
<?php require('structure/footer.php'); ?>


<!-- Script -->
<?php require('structure/script.php'); ?>

<!-- Script DataTable - User -->
<script>
$(document).ready(function() {
    var table = $('#user').DataTable( {
        "processing": true,
        "serverSide": true,
        "ajax": "loaduser.php?id=<?php echo (isset($_GET['id']) ? $_GET['id'] : ''); ?>",
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
         "order": [[ 1, 'desc' ]],
         responsive: true
    } );
    new $.fn.dataTable.FixedHeader( table );

    table.on( 'order.dt search.dt', function () {
        table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();

} );
</script>

<!-- Srcript Print Cer -->
<script>
function PrintCer(id) {
  var idpj = <?= $idpj ?> ;      
  window.location.href='print_cer.php?id=' + idpj  +'&'+ 'learn=' + id;        
}
</script>


</body>
</html>