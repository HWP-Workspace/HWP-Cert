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
      <div class="card-header text-white" id= "card-content-admin-project-tempate" > <h5 class="mt-2"> <i class="fas fa-arrow-down"></i> ดาวน์โหลดเทมเพลต</h5></div>
      <div class="card-body">
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs">
            <li class="nav-item">
              <a class="nav-link active"  id = "nav-admin-custom" href="admin_tempate.php" >เทมเพลต</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id = "nav-admin-custom" href="admin.php">กลับสู่หน้าหลัก</a>
            </li>
            </ul>
        </div>
      </div> 

        <div class="card-body">
          <div class="text-center">
            <img class= "img-cert" src="img/img_excert.jpg" alt="Tempate Cert" width="700" height="900">
            </div>
          <div class="row text-center pt-3"> 
          <div class="col"> <h6> ชื่อ-นามสกุล เท่านั้น </h6> <button onclick="window.location.href='example_file/example_tempate/name.psd'" type="button" class="btn btn-sm btn-primary"><i class="fas fa-file-download"></i> ดาวน์โหลด </button> </div> 
          <div class="col"> <h6> ชื่อ-นามสกุล + 1 บรรทัด</h6> <button onclick="window.location.href='example_file/example_tempate/line2.psd'" type="button" class="btn btn-sm btn-primary"><i class="fas fa-file-download"></i> ดาวน์โหลด </button> </div> 
          <div class="col"> <h6> ชื่อ-นามสกุล + 2 บรรทัด</h6> <button onclick="window.location.href='example_file/example_tempate/line3.psd'" type="button" class="btn btn-sm btn-primary"><i class="fas fa-file-download"></i> ดาวน์โหลด </button> </div> 

            </div>
          </div>
    </div>
  </div>
  </div>


<!--- Footer --->
<?php require('structure/footer.php'); ?>

<!-- Script -->
<?php require('structure/script.php'); ?>

</body>
</html>
