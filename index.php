<?php 
    session_start();
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

  <div class="text-center pt-5">
    <img src="img/fav.ico" alt="" width="150" height="150">
    <div class="text-center pt-3 pb-3">
      <h4 class="school-name"> ระบบพิมพ์เกียรติบัตรออนไลน์</h4>
      <p class="school-name"> <?php echo $nameschool_data ?> </p>
    </div>
  </div>



  <div class="card mt-4 mb-4 shadow-sm" >
    <div class="card-header text-white" id= "card-content">
      <h5 class="pt-1"><i class="fas fa-table pe-2"></i>ตารางแสดงโครงการ/กิจกรรม</h5>
    </div>
      <div class="card-body">
        <table id="loadproject" class="table table-bordered nowrap" style="width:100%">
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

    <!--- Footer --->
    <?php require('structure/footer.php'); ?>



<!-- Modal Login -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4> ล็อกอินเข้าสู่ผู้ดูแลระบบ</h4>
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
                  <button class="btn btn-primary" type="submit" name="login_user" >เข้าสู่ระบบ</button>
              </div> 
          </form>
      </div>

      </div>
    </div>
  </div>
</div>

<!-- Script -->
<?php require('structure/script.php'); ?>


<!-- Script DataTable-->  
<script>
$(document).ready(function() {
  
  var table = $('#loadproject').DataTable( {
        "processing": true,
        "serverSide": true,
        "ajax": "loadproject.php",
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
        { "width": "40%" },
        { "width": "33%" },
        { "width": "15%" },
        { "width": "5%" }
         ],

        "order": [[ 0, 'desc' ]],
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

<!-- Script Link Show User-->  
<script>
function UserRow(id){
    window.location.href='download.php?id=' + id;
      }

</script>

</body>
</html>