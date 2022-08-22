<?php 
session_start();
// เช็คล็อกอิน ถ้าหากไม่มี ให้กลับไปหน้า index.php
if (!isset($_SESSION['username'])) {
   header('location: index.php');
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>

<!--- Head --->
<?php require('structure/head.php'); ?>

</head>
<body>

<!--- nav --->
<?php require('structure/nav.php'); ?>

<!--- Card Content --->
<div class="container pt-4 d-block">
  <div class="card-deck mb-1">
    <!--- Card Content - Sub --->
    <div class="card mb-4 shadow-sm">
      <div class="card-header text-white" id= "card-content-admin" > <h5 class="mt-2"> <i class="fas fa-user-shield"></i> สำหรับเจ้าหน้าที่</h5></div>
      <div class="card-body">
        <div class="card-header">
          <div class="float-end text-white">
            <button class="btn btn-sm bg-primary text-white" data-bs-toggle="modal" data-bs-target="#AddPj" >  <i class="fas fa-plus pe-1"></i> เพิ่ม</dutton> 
        </div>
          <ul class="nav nav-tabs card-header-tabs">
            <li class="nav-item">
              <a class="nav-link active" href="admin.php" >โครงการ/กิจกรรม</a>
            </li>
          <?php  if ($_SESSION['username'] == "admin"){
            echo '
            
            <li class="nav-item">
            <a class="nav-link "  id = "nav-admin-custom" href="admin_user.php" >บัญชีผู้ใช้</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id = "nav-admin-custom" href="admin_setting.php">ตั้งค่าระบบ</a>
          </li>
            
            ';
          }
            ?>
            <li class="nav-item">
              <a class="nav-link "  id = "nav-admin-custom" href="admin_tempate.php" >เทมเพลต</a> 
            </li>
          </ul>
        </div>
      </div> 

        <div class="card-body">
            <table id="adminloadproject" class="table table-bordered nowrap" style="width:100%">
                    <thead class="table-light">
                        <tr>
                            <th>เลขที่</th>
                            <th>โครงการ/กิจกรรม</th>
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
                        </tr>
                    </tbody>
                </table>
          </div>
    </div>
  </div>
  </div>

  <!-- Modal Add Project -->
  <div class="modal fade" id="AddPj" tabindex="-1">
    <div class="modal-dialog ">
      <div class="modal-content ">
        <div class="modal-header">
          <h5> เพิ่มโครงการ/กิจกรรม </h5> 
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

              <form action="admincreateproject.php" method="post">
                <div class="mb-3">
                    <label class="form-label" for="name">ชื่อโครงการ/กิจกรรม</label>
                    <input class="form-control" type="text" name="name"  placeholder="โครงการ/กิจกรรม" required>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="date">วันที่</label>
                    <input class="form-control" type="date" name="date" required>
                    <div class="form-text">กรุณากรอกเป็น ค.ศ. ระบบจะแปลงเป็น พ.ศ. ให้อัตโนมัติ</div>
                </div>

                <div class="mb-3">
                  <label for="type" class="form-label">รูปแบบ</label>
                    <select class="form-select" name="type">
                      <option value="0" selected>ชื่อ-นามสกุล เท่านั้น</option>
                      <option value="1">ชื่อ-นามสกุล และเพิ่มอีก 1 บรรทัด</option>
                      <option value="2">ชื่อ-นามสกุล และเพิ่มอีก 2 บรรทัด</option>
                    </select>
                  </div>

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



  <!-- Modal Edit Project-->
  <div class="modal fade" id="EditPj" tabindex="-1">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5>แก้ไขข้อมูลโครงการ/กิจกรรม</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                    <select class="form-select" id="type">
                      <option value="0" selected>ชื่อ-นามสกุล เท่านั้น</option>
                      <option value="1">ชื่อ-นามสกุล และเพิ่มอีก 1 บรรทัด</option>
                      <option value="2">ชื่อ-นามสกุล และเพิ่มอีก 2 บรรทัด</option>
                    </select>
                  </div>

                  <input type="hidden" id="id-e">
                  <div class="text-center">
                <button type="sumbit" onclick="EditPj()" class="btn btn-primary"> <i class="fas fa-save"></i> แก้ไข</button>
                </form>
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
        <h5 class="modal-title">คุณกำลังจะลบโครงการ/กิจกรรม ?</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
          <div class="modal-body text-center">
          <form>
            <i class="mt-2 mb-2 fas fa-exclamation-circle fa-8x text-danger"></i>

            <h5 class="mt-3">คุณแน่ใจไหมที่จะลบโครงการ/กิจกรรม</h5>
            <h6 class="mt-1">ระบบจะลบผู้เข้าร่วมในโครงการ/กิจกรรมนี้ทั้งหมด</h5>

          </div>
          <div class="mb-4 mt-3 text-center"> 
          <input type="hidden" id="id-d">

            <button type="submit" onclick="DeletePj()" class="btn btn-danger"><i class="far fa-trash-alt"></i> ลบ</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-ban"></i> ยกเลิก</button>

            </form>
          </div>
    </div>
  </div>
</div>








<!--- Footer --->
<?php require('structure/footer.php'); ?>

<!-- Script -->
<?php require('structure/script.php'); ?>

<!-- Script DataTable - LoadProject-->
<script>
  $(document).ready(function() {
   var table = $('#adminloadproject').DataTable( {
        "processing": true,
        "serverSide": true,
        "ajax": "adminloadproject.php",
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
        { "width": "20%" },
        { "width": "13%" },
        { "width": "20%" }
         ],
        responsive: true
    } );
    new $.fn.dataTable.FixedHeader( table );
} );
</script>


<!-- Script DataTable - SettingPj Button -->
<script>
function SettingPj(id){
        $.ajax({
          url:"admin_project.php",
          method: "POST",
          data: {id:id}
        })
        location.href = "admin_project.php"
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
            url:'admindeleteproject.php',
            method: 'POST',
            data: {id:id},
            success:function(data){
             alert('ลบข้อมูลข้อมูลสำเร็จ');
              $('#adminloadadmin').DataTable().draw();
              $('#DeletePj').modal('toggle');
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
        url:'admineditproject_insert.php',
        method: 'POST',
        data: {id:id},
        success:function(data){
          var json = $.parseJSON(data);
          $("#name").val(json[0].name);
          $("#date").val(json[0].date);
          $("#type").val(json[0].type);
        }
      })
})

function EditPj(){
    var id = $('#id-e').val();
    var name = $('#name').val();
    var date = $('#date').val();
    var type = $('#type').val();
        $.ajax({
            url:'admineditproject.php',
            method: 'POST',
            data: {id:id,name:name,date:date,type:type},
            success:function(data){
             alert('แก้ไขข้อมูลข้อมูลสำเร็จ');
             $('#adminloadadmin').DataTable().draw();
             $('#EditPj').modal('toggle');
            }
          })    
}
</script>


<!-- Script Link Show Project-->  
<script>
function SettingPj(id){
    window.location.href='admin_editpj.php?id=' + id;
      }

</script>


</body>
</html>
