<?php 
    session_start();
    require('../../connect.php');
    
    if (isset($_POST['reg_user'])) {
        $username = mysqli_real_escape_string($con, $_POST['username']);
        $password_1 = mysqli_real_escape_string($con, $_POST['password_1']);
        $password_2 = mysqli_real_escape_string($con, $_POST['password_2']);
        $name = mysqli_real_escape_string($con, $_POST['name']);
        $iddp = mysqli_real_escape_string($con, $_POST['iddp']);
        
        $user_check_query = "SELECT `username` FROM `admin` WHERE `username` = '$username' ";
        $result1 = mysqli_query($con, $user_check_query) or die(mysqli_error());
        $num = mysqli_num_rows($result1);

        if ($num > 0) { // if user exists
            $msg = "ชื่อผู้ใช้งานซ้ำกันในระบบ [ERR-USER-CK]";
            $_SESSION['msg_w'] = $msg;
            header('location: ../../admin_user.php');
        }

        elseif ($password_1 != $password_2) {
            $msg = "รหัสผ่านไม่ตรงกัน [ERR-PW-CK]";
            $_SESSION['msg_w'] = $msg;
            header('location: ../../admin_user.php');
        }

        else {
            $password = md5($password_1);

            $sql = "INSERT INTO `admin` (`username`, `password`, `name`, `iddp`) VALUES ('$username', '$password', '$name', '$iddp')";
            $res = mysqli_query($con, $sql);
            if (false === $res) {
                die(mysqli_error($con));
            }
            $msg = "เพิ่มผู้ดูแลระบบสำเร็จ [SUCCESS]";
            $_SESSION['msg_s'] = $msg;
            header('location: ../../admin_user.php');
        } 
    
    }

?>