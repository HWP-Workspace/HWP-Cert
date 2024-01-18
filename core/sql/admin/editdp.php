<?php
require('../../connect.php');

if(isset($_POST["id"]) && isset($_POST["name"]) && isset($_POST["shortdp"])){

    $id = mysqli_real_escape_string($con,$_POST["id"]);
    $name = mysqli_real_escape_string($con,$_POST["name"]);
    $shortdp = mysqli_real_escape_string($con,$_POST["shortdp"]);

    $sql = "UPDATE `dp` SET `name` = '$name', `shortdp` = '$shortdp' WHERE `id` = ".$id;    
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