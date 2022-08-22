<?php
session_start();
require('../../connect.php');

if(isset($_POST['name']) && isset($_POST['date']) && isset($_POST['type']) ){

    if(isset($_POST['iddp'])){
        $iddp = mysqli_real_escape_string($con,$_POST['iddp']);
    }else{
        $username = $_SESSION['username'];
        $query_pj = "SELECT `iddp` FROM `admin` WHERE `username` = '".$username."' "; // คำสั่ง sql
        $result_pj = mysqli_query($con,$query_pj); 
    
            while ($row = mysqli_fetch_assoc($result_pj)) {
                $iddp = $row['iddp'];
                break;
            }
    }

    $name = mysqli_real_escape_string($con,$_POST['name']);
    $date = mysqli_real_escape_string($con,$_POST['date']);
    $type = mysqli_real_escape_string($con,$_POST['type']);

    $sql_cp = " INSERT INTO `project`(`name`, `iddp`, `date`, `tempate`, `preview`, `font`, `size_name`, `size_line2`, `size_line3`, `margin`, `color`, `type`) VALUES('$name', '$iddp', '$date', '', '', 'thsarabunnew', '48', '36', '36', '210','#000000', '$type')";
    $res = mysqli_query($con, $sql_cp);

    if (false === $res) {
        die(mysqli_error($con));
    }

    $msg = "บันทึกโครงการ/กิจกรรมสำเร็จ [SUCCESS]";
    $_SESSION['msg_s'] = $msg;
    header('location: ../../admin.php');
}


else{
    echo 'ท่านเรียนใช้งานไม่ถูกต้อง [ERROR-ID]';
}

?>