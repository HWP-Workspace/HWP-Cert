<?php
require('../../connect.php');

if(isset($_POST["id"]) && isset($_POST["font"]) && isset($_POST["margin"]) && isset($_POST["color"]) && isset($_POST["size_name"])){

    $id = mysqli_real_escape_string($con,$_POST["id"]);
    $font = mysqli_real_escape_string($con,$_POST["font"]);
    $margin = mysqli_real_escape_string($con,$_POST["margin"]);
    $color = mysqli_real_escape_string($con,$_POST["color"]);
    $size_name = mysqli_real_escape_string($con,$_POST["size_name"]);
    $size_line2 = mysqli_real_escape_string($con,$_POST["size_line2"]); 
    $size_line3 = mysqli_real_escape_string($con,$_POST["size_line3"]); 

    if(!empty($size_line2) && !empty($size_line3) ){
    $sql = "UPDATE `project` SET `font` = '$font', `margin` = '$margin', `color` = '$color', `size_name` = '$size_name', `size_line2` = '$size_line2', `size_line3` = '$size_line3' WHERE `id` = ".$id;    
    }elseif(!empty($size_line2) && empty($size_line3) ){
    $sql = "UPDATE `project` SET `font` = '$font', `margin` = '$margin', `color` = '$color', `size_name` = '$size_name', `size_line2` = '$size_line2' WHERE `id` = ".$id;    
    }elseif(!empty($size_line3) && empty($size_line2) ){
    $sql = "UPDATE `project` SET `font` = '$font', `margin` = '$margin', `color` = '$color', `size_name` = '$size_name', `size_line3` = '$size_line3' WHERE `id` = ".$id;    
    }else{
    $sql = "UPDATE `project` SET `font` = '$font', `margin` = '$margin', `color` = '$color', `size_name` = '$size_name' WHERE `id` = ".$id;    
    }
   
    $res = mysqli_query($con,$sql);

    if (false === $res) {
        die(mysqli_error($con));
    }

    mysqli_close($con);

}

else{
    echo 'ท่านเรียกใช้งานไม่ถูกต้อง [ERR-ID]';
}

?>