<?php 
    session_start();
    require('connect.php');

  if (isset($_POST['login_user'])) {
        $username = mysqli_real_escape_string($con, $_POST['username']);
        $password = mysqli_real_escape_string($con, $_POST['password']);
        $password = md5($password); // แปลงรหัส md5
        $query = "SELECT * FROM `admin` WHERE `username` = '$username' AND `password` = '$password' "; // คำสั่ง sql
        $result = mysqli_query($con, $query);
        if (false === $result) {
            die(mysqli_error($con));
        }


    if (mysqli_num_rows($result) == 1){
    $_SESSION['username'] = $username;

    //ดึง dp จากฐานข้อมูล
    $query_dp = "SELECT `dp` FROM `admin` WHERE `username` = '$username' "; 
    $result_dp = mysqli_query($con,$query_dp); 

    if (false === $result_dp) {
        die(mysqli_error($con));
    }

    while ($row_dp = mysqli_fetch_assoc($result_dp)) {
               $dp_data = $row_dp['dp'];
               break;
    }

    // Echo 

    echo"<script>";
    echo "alert('ยินดีต้อนรับกลับ, $dp_data');"; 
        // คำสั่ง replace - java
    echo "location.replace('admin.php');";
    echo "</script>";
    } 
            
    else{
    echo"<script>"; 
    echo "alert('ชื่อผู้ใช้ หรือ รหัสผ่าน ไม่ถูกต้อง');"; 
        // คำสั่ง replace - java
    echo "location.replace('index.php');";
    echo "</script>";
    }

    }

?>