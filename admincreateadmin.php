<?php 
    session_start();
    include('connect.php');
    
    if (isset($_POST['reg_user'])) {
        $username = mysqli_real_escape_string($con, $_POST['username']);
        $password_1 = mysqli_real_escape_string($con, $_POST['password_1']);
        $password_2 = mysqli_real_escape_string($con, $_POST['password_2']);
        $name = mysqli_real_escape_string($con, $_POST['name']);
        $dp = mysqli_real_escape_string($con, $_POST['dp']);
        $shortdp = mysqli_real_escape_string($con, $_POST['shortdp']);
        
        $user_check_query = "SELECT * FROM `admin` WHERE `username` = '$username' LIMIT 1";
        $query = mysqli_query($con, $user_check_query);
        $result = mysqli_fetch_assoc($query);

        if ($result) { // if user exists
            echo"<script>";
            echo "alert(\"ชื่อผู้ใช้ซ้ำกันในระบบ\");"; 
                // คำสั่ง replace - java
            echo " location.replace('admin_user.php') ";
            echo "</script>";
        }

        if ($password_1 != $password_2) {
            echo"<script>";
            echo "alert(\"รหัสผ่านไม่ตรงกัน\");"; 
                // คำสั่ง replace - java
            echo " location.replace('admin_user.php')  ";
            echo "</script>";
        }

        else {
            $password = md5($password_1);

            $sql = "INSERT INTO `admin` (`username`, `password`, `name`, `dp`, `shortdp`) VALUES ('$username', '$password', '$name', '$dp', '$shortdp')";
            $res = mysqli_query($con, $sql);
            if (false === $res) {
                die(mysqli_error($con));
            }
            header('location: admin_user.php');
        } 
    
    }

?>