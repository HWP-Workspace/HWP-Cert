<?php
session_start();
require('../../connect.php');

// ถ้าช่อง password ไม่เท่ากับ ค่าว่าง ให้แก้ไข password ด้วย
if(!empty($_POST["password"])){
        $username = mysqli_real_escape_string($con,$_POST["username"]);
        $name = mysqli_real_escape_string($con,$_POST["name"]);
        $iddp = mysqli_real_escape_string($con,$_POST["iddp"]);
        $password = mysqli_real_escape_string($con,$_POST["password"]);
        $password = md5($password);
    
        $sql = "UPDATE `admin` SET `username` = '$username', `name` = '$name', `iddp` = '$iddp', `password` = '$password' WHERE `id` = ".$_POST["id"];
        $res_editp = mysqli_query($con,$sql);
        if (false === $res_editp) {
            die(mysqli_error($con));
        }
        mysqli_close($con);
}

elseif(isset($_POST["username"]) && isset($_POST["name"])  && isset($_POST["iddp"]) ){

    $username = mysqli_real_escape_string($con,$_POST["username"]);
    $name = mysqli_real_escape_string($con,$_POST["name"]);
    $iddp = mysqli_real_escape_string($con,$_POST["iddp"]);
    
    $sql = "UPDATE admin SET `username` = '$username', `name` = '$name', `iddp` = '$iddp' WHERE `id` = ".$_POST["id"];

    
    $res_edit = mysqli_query($con,$sql);

    if (false === $res_edit) {
        die(mysqli_error($con));
    }

    mysqli_close($con);
}

else{
    echo 'ท่านเรียกใช้งานไม่ถูกต้อง [ERROR-ID]';
}   


?>