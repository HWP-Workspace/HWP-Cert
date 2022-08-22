<?php 
session_start();
// เช็คล็อกอิน ถ้าหากไม่มี ให้กลับไปหน้า index.php
if (!isset($_SESSION['username'])) {
   header('location: index.php');
    }
// หากล็อกเอ้าท์ออกมา ให้ลบ session ให้กลับไปยัง index.php
if (isset($_GET['logout'])) {
  session_destroy();
  unset($_SESSION['username']);
  header('location: index.php');
    }

      //รับชื่อโครงการ
require('connect.php');
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
$query_type = "SELECT `type` FROM `project` WHERE `id` =".$id; 
$result_type = mysqli_query($con,$query_type); 

if (false === $result_type) {
  die(mysqli_error($con));
}

while ($row_type = mysqli_fetch_assoc($result_type)) {
           $type_data = $row_type['type'];
           break;
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
      <div class="card-header text-white" id= "card-content-admin-project" > <h6 class="mt-2"> <i class="far fa-edit"></i> แก้ไขข้อมูลโครงการ/กิจกรรม : <?php echo $namepj_data ?> </h6></div>
      <div class="card-body">
        <div class="card-header">
          <div class="float-end text-white">
            <button class="btn bg-primary btn btn-sm text-white me-1" data-bs-toggle="modal" data-bs-target="#AddUser" >  <i class="fas fa-plus pe-1"></i> เพิ่ม</dutton> 

          <form action="admineditpj_deleteall.php" method="post">
          <?php if($num_user > 0) { 
                        echo " 
                        <input type=\"hidden\" name=\"id\" value=\"$id\">
                        <button type=\"submit\" class=\"btn btn-sm bg-danger text-white\"> <i class=\"fas fa-trash pe-1\"></i> ลบทั้งหมด</dutton>";}?>
          </form>
        
        </div>
          <ul class="nav nav-tabs card-header-tabs">
            <li class="nav-item">
              <a class="nav-link active" href="admin_project.php" >รายชื่อทั้งหมด</a>
            </li>
            <li class="nav-item">
              <a class="nav-link " id = "nav-admin-custom" data-bs-toggle="modal" data-bs-target="#AddCSV"  >นำเข้ารายชื่อ</a>
            </li>
            <li class="nav-item">
              <a class="nav-link "  id = "nav-admin-custom" data-bs-toggle="modal" data-bs-target="#AddTempate"  >อัปโหลดแม่แบบเกียรติบัตร</a> 
            </li>
            <li class="nav-item">
              <a class="nav-link" id = "nav-admin-custom" href="admin.php">กลับสู่หน้าหลัก </a>
            </li>
          </ul>
        </div>
      </div> 

        <div class="card-body">
            <table id="adminloaduser" class="table table-bordered nowrap" style="width:100%">
                    <thead class="table-light">
                        <tr>
                            <th>ชื่อ-นามสกุล</th>
                            <th>เลขที่เกียรติบัตร</th>
                            <th>ดำเนินการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
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

<!-- Modal Upload Excel -->
  <div class="modal fade" id="AddCSV" tabindex="-1">
    <div class="modal-dialog ">
      <div class="modal-content ">
        <div class="modal-header">
          <h5> นำเข้ารายชื่อ </h5> 
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
              <form action="excel/admineditpj_excel.php" method="post" enctype="multipart/form-data">

                <div class="mb-3">
                    <label class="form-label" for="name">กรุณาอัปโหลดไฟล์ .csv (UTF-8) หรือ .xlsx เท่านั้น</label>
                    <input class="form-control" type="file" name="file" accept=".csv, .xlsx" required>
                </div>

                <label class="form-label pe-3" for="name">ตัวอย่างไฟล์ </label>
                 <a class ="text-success" href="example_file/example_excel/example.csv" > <i class="fas fa-file-excel"></i> example.csv </a> 
                 <a class ="text-success ms-3" href="example_file/example_excel/example.xlsx" > <i class="fas fa-file-excel"></i> example.xlsx </a>

                 <input type="hidden" name="id" value="<?=$_GET['id']?>"> 
                <div class="text-center mt-3">
                    <button class="btn btn-primary" type="submit" name="import" class="btn"> <i class="fas fa-file-import"></i> นำเข้า</button>
                </div> 
            </form>
          </div>
        </div>
      </div>
    </div>
</div>


<!-- Modal Upload Tempate -->
<div class="modal fade" id="AddTempate" tabindex="-1">
      <div class="modal-dialog ">
        <div class="modal-content ">
          <div class="modal-header">
            <h5> อัปโหลดแม่แบบเกียรติบัตร </h5> 
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">

                <form action="admineditpj_img.php" method="post" enctype="multipart/form-data">

                  <div class="mb-3">
                      <label class="form-label" for="tempate">กรุณาอัปโหลดไฟล์ .jpg .png .jpeg เท่านั้น</label>
                      <input class="form-control" type="file" name="upload" accept=".png, .jpg, .jpeg" required>
                  </div>
                  
                  <?php 
                  if(!empty($img_data)){
                   echo  "<label class=\"form-label\" for=\"name\"> <div class=\"mb-2\">รูปแบบ : </div>  <img class=\"img-cert\" src=\"tempate/$img_data\"></label>" ;
                  }   
                  ?>

                  <input type="hidden" name="id" value="<?=$_GET['id']?>" > 
                  <div class="text-center mt-3">
                      <button class="btn btn-primary" type="submit" name="submit" class="btn"> <i class="fas fa-file-import"></i> นำเข้า</button>
                  </div> 
              </form>
              
            </div>
          </div>
        </div>
      </div>
</div>

<!-- Modal Edit User-->
<div class="modal fade" id="EditUser" tabindex="-1">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5>แก้ไขผู้เข้าร่วมโครงการ/กิจกรรม</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                <button type="sumbit" onclick="EditUser()" class="btn btn-primary"> <i class="fas fa-save"></i> แก้ไข</button>
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
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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

<!-- Modal Delete -->
<div class="modal fade" id="DeleteUser" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">คุณกำลังจะลบผู้เข้าร่วมโครงการ/กิจกรรม ? </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
          <div class="modal-body text-center">
          <form>
            <i class="mt-2 mb-2 fas fa-exclamation-circle fa-8x text-danger"></i>

            <h5 class="mt-3">คุณแน่ใจไหมที่จะลบผู้เข้าร่วมโครงการ/กิจกรรม </h5>
            <h6 class="mt-1">หากลบแล้วการรันเลขเกียรติบัตรจะไม่ต่อเนื่องกัน</h5>

          </div>
          <div class="mb-4 mt-3 text-center"> 
          <input type="hidden" id="id">
            <button type="submit" onclick="DeleteUser()" class="btn btn-danger">ลบ</button>
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

<!-- Script DataTable - LoadProjectAdmin-->
<script>
  $(document).ready(function() {
   var table = $('#adminloaduser').DataTable( {
        "processing": true,
        "serverSide": true,
        "ajax": "admineditpj_loaduser.php?id=<?php echo (isset($_GET['id']) ? $_GET['id'] : ''); ?>",
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
        { "width": "50%" },
        { "width": "40%" },
        { "width": "10%" }
         ],
        responsive: true
    } );
    new $.fn.dataTable.FixedHeader( table );
} );
</script>

<!-- Script DataTable - EditUser Button -->
<script>
  $('#EditUser').on('shown.bs.modal', function (event) {

    var button = $(event.relatedTarget) 
    var id = button.data('whatever') 
    var modal = $(this)

    $('#id').val(id);

    $.ajax({
        url:'admineditpj_edituser-insert.php',
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

function EditUser(){
    var id = $('#id').val();
    var name = $('#name').val();
    var line2 = $('#line2').val();
    var line3 = $('#line3').val();
        $.ajax({
            url:'admineditpj_edituser.php',
            method: 'POST',
            data: {id:id,name:name,line2:line2,line3:line3},
            success:function(data){
              alert('แก้ไขข้อมูลข้อมูลสำเร็จ');
              window.location.reload();
            }
          })  
  }
</script>

<!-- Script DataTable - DeleteUser Button -->
<script>
  $('#DeleteUser').on('shown.bs.modal', function (event) {

    var button = $(event.relatedTarget);
    var id = button.data('whatever');
    var modal = $(this);

    $('#id').val(id);
})

function DeleteUser(){
    var id = $('#id').val();

        $.ajax({
            url:'admineditpj_delete.php',
            method: 'POST',
            data: {id:id},
            success:function(data){
             alert('ลบข้อมูลข้อมูลสำเร็จ');
             window.location.reload();
            }
          })
  }
</script>



</body>
</html>
