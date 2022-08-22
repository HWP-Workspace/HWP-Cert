<?php
session_start();
require('../../connect.php');


if(isset($_POST['name']) && isset($_POST['shortdp']) ){

    $name = mysqli_real_escape_string($con,$_POST['name']);
    $shortdp = mysqli_real_escape_string($con,$_POST['shortdp']);

    $sql_cp = " INSERT INTO `dp`(`id`, `name`, `shortdp`) VALUES(null, '$name', '$shortdp')";
    $res = mysqli_query($con, $sql_cp);

    if (false === $res) {
        die(mysqli_error($con));
    }

    $msg = "บันทึกกลุ่ม/งานสำเร็จ [SUCCESS]";
    $_SESSION['msg_s'] = $msg;
    header('location: ../../admin_dp.php');
}


else{
    echo 'ท่านเรียนใช้งานไม่ถูกต้อง [ERROR-ID]';
}

?>