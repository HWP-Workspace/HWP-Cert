<?php
require('../../connect.php');
session_start();

//ลบ user ทั้งหมดภายใต้ idpj
if(isset($_POST['id'])){
    $id = mysqli_real_escape_string($con, $_POST['id']);
    $check = "SELECT * FROM `user` WHERE `idpj` =".$id;
	$result_nouser  = mysqli_query($con, $check);
    if (false === $result_nouser) {
        die(mysqli_error($con));
    }
	$num = mysqli_num_rows($result_nouser); 

     if($num == 0){
        echo "<script>";
        echo "alert(\"ไม่มีชื่อผู้เข้าร่วมกิจกรรม/โครงการ อยู่ในฐานข้อมูล!\");"; 
            // คำสั่ง replace - java
        echo "location.replace(\"admin_editpj.php?id=$id\");";
        echo "</script>";
    }

    else{
        $id = mysqli_real_escape_string($con, $_POST['id']);
        $sql = "DELETE FROM `user` WHERE `idpj` =".$id;
        $result_deluser =  mysqli_query($con, $sql);
        if (false === $result_deluser) {
            die(mysqli_error($con));
        }

        $msg = "ลบผู้เข้าร่วมสำเร็จ [SUCCESS]";
        $_SESSION['msg_s'] = $msg;
        header("Location: ../../admin_pj.php?id=$id");

    }

}
else{
    echo "ท่านเรียกใช้งานไม่ถูกต้อง [ERR-ID]";
}

?>