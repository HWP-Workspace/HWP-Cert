<?php
require('../../connect.php');

//ลบ project
if(isset($_POST["id"])){

    //รับค่า tempate
    $query_tempate = "SELECT `tempate` FROM `project` WHERE `id` =".$_POST["id"];
    $result_tempate = mysqli_query($con,$query_tempate); 

    if (false === $result_tempate) {
        die(mysqli_error($con));
    }

    while ($row_tempate = mysqli_fetch_assoc($result_tempate)) {
            $tempate_data = $row_tempate['tempate'];
            break;
    }

// ลบ Teampate
    unlink('../../upload/tempate/'.$tempate_data);

// ลบ Project
    $sql = "DELETE FROM `project` WHERE `id` = ".$_POST["id"];
    $res_delpj = mysqli_query($con,$sql);
    if (false === $res_delpj) {
        die(mysqli_error($con));
    }

// ลบ User ภายใต้ Project
    $sql_user = "DELETE FROM `user` WHERE `idpj` = ".$_POST["id"];
    $res_delid = mysqli_query($con,$sql_user);
    if (false === $res_delid) {
        die(mysqli_error($con));
    }
}

else{
    echo 'ท่านเรียกใช้งานไม่ถูกต้อง [ERROR-ID]';
}



?>