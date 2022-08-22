<?php 
    session_start();
// เช็คล็อกอิน ถ้าหากไม่มี ให้กลับไปหน้า index.php
    if (!isset($_SESSION['username'])) {
        header('location: index.php');
    }

// session admin เท่านั้นจึงจะเข้าสู่หน้านี้ได้
if ($_SESSION['username'] != "admin") {
  header('location: admin.php');
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
<div class="container pt-4">
  <div class="card-deck mb-1">
      <div class="card mb-4 shadow-sm">
        <div class="card-header text-white" id= "card-content-admin"> <h5 class="mt-2"> <i class="fas fa-user-shield"></i> สำหรับเจ้าหน้าที่</h5></div>
          <div class="card-body">
            <div class="card-header">
              <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item">
                  <a class="nav-link" id = "nav-admin-custom" href="admin.php">โครงการ/กิจกรรม</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id = "nav-admin-custom" href="admin_user.php">บัญชีผู้ใช้</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link active"  href="admin_setting.php">ตั้งค่าระบบ</a>
                </li>
                <li class="nav-item">
              <a class="nav-link "  id = "nav-admin-custom" href="admin_tempate.php" >เทมเพลต</a> 
              </li>
              </ul>
            </div>
            <div class="card-body">
              <table id="loadschooladmin" class="table table-bordered nowrap" style="width:100%">
                          <thead class="table-light ">
                              <tr>
                                  <th>เลขที่</th>
                                  <th>ชื่อโรงเรียน</th>
                                  <th>ชื่อย่อโรงเรียน</th>
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

  <!-- Modal Edit School-->
<div class="modal fade" id="EditSchool" tabindex="-1">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5>แก้ไขข้อมูลสถานศึกษา/โรงเรียน</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form onsubmit="EditSchool()">

                <div class="mb-3">
                      <label for="name" class="form-label">ชื่อโรงเรียน</label>
                      <input type="text" class="form-control" id="name" required>
                  </div>

                  <div class="mb-3">
                      <label for="name" class="form-label">ชื่อย่อโรงเรียน</label>
                      <input type="text" class="form-control" id="shortname" required>
                  </div>

                  <input type="hidden" id="id">
                  <div class="text-center">
                <button type="submit" class="btn btn-primary"> <i class="fas fa-save"></i> แก้ไข</button>
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

<!-- Script DataTable - Loadschool -->
<script>
  $(document).ready(function() {
  var table =  $('#loadschooladmin').DataTable( {
        "processing": true,
        "serverSide": true,
        "ajax": "adminloadschool.php",
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
        { "width": "60%" },
        { "width": "28%" },
        { "width": "5%" }
      ],
        responsive: true
    } );
    new $.fn.dataTable.FixedHeader( table );
} );
</script>

<!-- Script DataTable - EditAdmin Button -->
<script>
$('#EditSchool').on('shown.bs.modal', function (event) {

    var button = $(event.relatedTarget) 
    var id = button.data('whatever') 
    var modal = $(this)

    $('#id').val(id);

    $.ajax({
        url:'admineditschool_insert.php',
        method: 'POST',
        data: {id:id},
        success:function(data){
          var json = $.parseJSON(data);
          $("#name").val(json[0].name);
          $("#shortname").val(json[0].shortname);
        }
      })
})

function EditSchool(){
    var id = $('#id').val();
    var name = $('#name').val();
    var shortname = $('#shortname').val();

        $.ajax({
            url:'admineditschool.php',
            method: 'POST',
            data: {id:id,name:name,shortname:shortname},
            success:function(data){
              alert('แก้ไขข้อมูลข้อมูลสำเร็จ')
              $('loadschooladmin').DataTable().draw()
              $('#EditSchool').modal('toggle')
            }
          })
}
</script>

</body>
</html>

