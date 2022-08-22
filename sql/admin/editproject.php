<?php
require('../../connect.php');

if(isset($_POST["name"]) && isset($_POST["date"]) && isset($_POST["type"])){

    $name = mysqli_real_escape_string($con,$_POST["name"]);
    $date = mysqli_real_escape_string($con,$_POST["date"]);
    $type = mysqli_real_escape_string($con,$_POST["type"]);
    $iddp = mysqli_real_escape_string($con,$_POST["iddp"]);

    if(!empty($iddp)){
        if($type == 0){
            $sql = "UPDATE `project` SET `iddp` = '$iddp', `name` = '$name', `date` = '$date', `type` = '$type', `size_line2` = '36', `size_line3` = '36' WHERE `id` = ".$_POST["id"];
            }elseif($type == 1){
            $sql = "UPDATE `project` SET `iddp` = '$iddp', `name` = '$name', `date` = '$date', `type` = '$type', `size_line3` = '36' WHERE `id` = ".$_POST["id"];
            }elseif($type == 2){
            $sql = "UPDATE `project` SET `iddp` = '$iddp', `name` = '$name', `date` = '$date', `type` = '$type' WHERE `id` = ".$_POST["id"];
            }
        
            $res = mysqli_query($con,$sql);
        
            if (false === $res) {
                die(mysqli_error($con));
            }
        
            // ลบข้อมูลใน User บรรทัด 2/3 ที่ไม่ได้ใช้
            if($type == 0){
            $sql_user = "UPDATE `user` SET `iddp` = '$iddp', line2 = '', line3 = '' WHERE `idpj` = ".$_POST["id"];
            }elseif($type == 1){
            $sql_user = "UPDATE `user` SET `iddp` = '$iddp', line3 = '' WHERE `idpj` = ".$_POST["id"];
            }
            $res_user = mysqli_query($con,$sql_user);
        
            if (false === $res_user) {
                die(mysqli_error($con));
            }
        
            mysqli_close($con);
            
    }else{
        if($type == 0){
            $sql = "UPDATE `project` SET `name` = '$name', `date` = '$date', `type` = '$type', `size_line2` = '36', `size_line3` = '36' WHERE `id` = ".$_POST["id"];
            }elseif($type == 1){
            $sql = "UPDATE `project` SET `name` = '$name', `date` = '$date', `type` = '$type', `size_line3` = '36' WHERE `id` = ".$_POST["id"];
            }elseif($type == 2){
            $sql = "UPDATE `project` SET `name` = '$name', `date` = '$date', `type` = '$type' WHERE `id` = ".$_POST["id"];
            }
        
            $res = mysqli_query($con,$sql);
        
            if (false === $res) {
                die(mysqli_error($con));
            }
        
            // ลบข้อมูลใน User บรรทัด 2/3 ที่ไม่ได้ใช้
            if($type == 0){
            $sql_user = "UPDATE `user` SET line2 = '', line3 = '' WHERE `idpj` = ".$_POST["id"];
            }elseif($type == 1){
            $sql_user = "UPDATE `user` SET line3 = '' WHERE `idpj` = ".$_POST["id"];
            }
            $res_user = mysqli_query($con,$sql_user);
        
            if (false === $res_user) {
                die(mysqli_error($con));
            }
        
            mysqli_close($con);
    }
}

else{
    echo 'ท่านเรียกใช้งานไม่ถูกต้อง [ERR-ID]';
}

?> 