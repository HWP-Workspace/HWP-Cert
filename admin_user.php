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
    <!--- Card Content - Sub --->
    <div class="card mb-4 shadow-sm">
      <div class="card-header text-white" id= "card-content-admin"> <h5 class="mt-2"> <i class="fas fa-user-shield"></i> สำหรับเจ้าหน้าที่</h5></div>
      <div class="card-body">
        <div class="card-header">
          <div class="float-end text-white">
            <button class="btn bg-primary text-white btn-sm"  data-bs-toggle="modal" data-bs-target="#AddAdmin" > <i class="fas fa-plus pe-1"></i> เพิ่ม</dutton> 
        </div>
          <ul class="nav nav-tabs card-header-tabs">
            <li class="nav-item">
              <a class="nav-link" id = "nav-admin-custom" href="admin.php">โครงการ/กิจกรรม</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active"  href="admin_user.php">บัญชีผู้ใช้</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id = "nav-admin-custom" href="admin_setting.php">ตั้งค่าระบบ</a>
            </li>
            <li class="nav-item">
              <a class="nav-link "  id = "nav-admin-custom" href="admin_tempate.php" >เทมเพลต</a> 
            </li>
          </ul>
        </div>
      </div> 
      <div class="card-body">
            <table id="loadadmin" class="table table-bordered nowrap" style="width:100%">
                    <thead class="table-light ">
                        <tr>
                            <th>เลขที่</th>
                            <th>ชื่อผู้ใช้</th>
                            <th>ชื่อผู้ดูแล</th>
                            <th>กลุ่ม/งาน</th>
                            <th>ชื่อย่อ กลุ่ม/งาน</th>
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

  <!-- Modal Edit Project-->
  <div class="modal fade" id="EditAdmin" tabindex="-1">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5>แก้ไขข้อมูลผู้ดูแลระบบ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form  onsubmit="EditAdmin()">
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
                      <label for="dp" class="form-label">กลุ่ม/งาน</label>
                      <input type="text" class="form-control" id="dp" required>
                  </div>

                  <div class="mb-3">
                      <label for="shortdp" class="form-label">ชื่อย่อกลุ่ม/งาน</label>
                      <input type="text" class="form-control" id="shortdp" required>
                  </div>

                  <hr>
                  <div class="mb-3">
                      <label for="name" class="form-label">รหัสผ่าน (ถ้าต้องการแก้ไข)</label>
                      <input type="password" class="form-control" id="password" minlength="8">
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

 <!-- Modal Add Admin -->
<div class="modal fade" id="AddAdmin" tabindex="-1">
    <div class="modal-dialog ">
      <div class="modal-content ">
        <div class="modal-header">
          <h5> เพิ่มผู้ดูแลระบบ </h5> 
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

              <form action="admincreateadmin.php" method="post">
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
                      <label for="dp" class="form-label">กลุ่ม/งาน</label>
                      <input type="text" class="form-control" name="dp" placeholder="กลุ่ม/งาน" required>
                  </div>

                  <div class="mb-3">
                      <label for="shortdp" class="form-label">ชื่อย่อกลุ่ม/งาน</label>
                      <input type="text" class="form-control" name="shortdp" placeholder="ชื่อย่อกลุ่ม/งาน" required>
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
<div class="modal fade" id="DeleteAdmin" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">คุณกำลังจะลบผู้ใช้งาน ?</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
          <div class="modal-body text-center">
          <form>
            <i class="mt-2 mb-2 fas fa-exclamation-circle fa-8x text-danger"></i>

            <h5 class="mt-3">คุณแน่ใจไหมที่จะลบผู้ใช้งาน</h5>
            <h6 class="mt-1">หากกลบแล้วผู้ใช้งานจะไม่สามารถเข้าสู่ระบบได้</h5>

          </div>
          <div class="mb-4 mt-3 text-center"> 
          <input type="hidden" id="id-d">
            <button type="submit" onclick="DeleteAdmin()" class="btn btn-danger">ลบ</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
            </form>
      </div>
    </div>
  </div>
</div>


<!--- Footer --->
<?php require('structure/footer.php'); ?>

<!-- Script -->
<?php require('structure/script.php'); ?>

<!-- Script DataTable - LoadAdmin -->
<script>
  $(document).ready(function() {
   var table = $('#loadadmin').DataTable( {
        "processing": true,
        "serverSide": true,
        "ajax": "adminloadadmin.php",
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
        { "width": "8%" },
        { "width": "16%" },
        { "width": "22%" },
        { "width": "30%" },
        { "width": "15%" },
        { "width": "9%" }
      ],
        responsive: true
    } );
    new $.fn.dataTable.FixedHeader( table );
} );
</script>

<!-- Script DataTable - DeleteAdmin Button -->
<script>
  $('#DeleteAdmin').on('shown.bs.modal', function (event) {

    var button = $(event.relatedTarget);
    var id = button.data('whatever');
    var modal = $(this);

    $('#id-d').val(id);
})

function DeleteAdmin(){
    var id = $('#id-d').val();

        $.ajax({
            url:'admindeleteadmin.php',
            method: 'POST',
            data: {id:id},
            success:function(data){
             alert('ลบข้อมูลข้อมูลสำเร็จ');
              $('#adminloadadmin').DataTable().draw();
              $('#DeleteAdmin').modal('toggle');
            }
          })
  }
</script>


<!-- Script DataTable - EditAdmin Button -->
<script>
$('#EditAdmin').on('shown.bs.modal', function (event) {

      var button = $(event.relatedTarget) 
      var id = button.data('whatever') 
      var modal = $(this)

      $('#id').val(id);

      $.ajax({
          url:'admineditadmin_insert.php',
          method: 'POST',
          data: {id:id},
          success:function(data){
            var json = $.parseJSON(data);
            $("#username").val(json[0].username);
            $("#name").val(json[0].name);
            $("#dp").val(json[0].dp);
            $("#shortdp").val(json[0].shortdp);
          }
        })
})


function EditAdmin(){
    var id = $('#id').val();
    var name = $('#name').val();
    var username = $('#username').val();
    var password = $('#password').val();
    var dp = $('#dp').val();
    var shortdp = $('#shortdp').val();

        $.ajax({
            url:'admineditadmin.php',
            method: 'POST',
            data: {id:id,username:username,password:password,name:name,dp:dp,shortdp:shortdp},
            success:function(data){
              alert('แก้ไขข้อมูลข้อมูลสำเร็จ')
              $('#loadadmin').DataTable().draw()
              $('#EditAdmin').modal('toggle')
            }
          })
}
</script>


</body>
</html>
