<?php 
    session_start();
    require('../../connect.php');

  if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = mysqli_real_escape_string($con, $_POST['username']);
        $password = mysqli_real_escape_string($con, $_POST['password']);
        $password = md5($password); // แปลงรหัส md5
        
        $query = "SELECT `username`, `password` FROM `admin` 
        WHERE `username` = '$username' AND `password` ='$password'";
    
    // คำสั่ง sql
        $result = mysqli_query($con, $query);
        if (false === $result) {
            die(mysqli_error($con));
        }


      if (mysqli_num_rows($result) == 1){
        
        $_SESSION['username'] = $username;
        echo "S";

      } 
            
    else{
      echo "ชื่อผู้ใช้ หรือ รหัสผ่านไม่ถูกต้อง [ERR-CK-LOGIN]";
    }

}


else{
      echo 'ท่านเรียกใช้งานไม่ถูกต้อง [ERROR]';
  }  

?>