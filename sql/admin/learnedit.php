<?php
session_start();
require('../../connect.php');

if(isset($_POST["id"]) && isset($_POST["name"]) || isset($_POST["line2"]) || isset($_POST["line3"]) ){

    $id = mysqli_real_escape_string($con,$_POST["id"]);
    $name = mysqli_real_escape_string($con,$_POST["name"]);
    $line2 = mysqli_real_escape_string($con,$_POST["line2"]);
    $line3 = mysqli_real_escape_string($con,$_POST["line3"]);

    $sql = "UPDATE `user` SET `name` = '$name', `line2` = '$line2', `line3` = '$line3' WHERE `id` = '$id' ";

    $res = mysqli_query($con,$sql);
    if (false === $res) {
        die(mysqli_error($con));
    }
    
    mysqli_close($con);
    }

else{
    echo 'ท่านเรียนใช้งานไม่ถูกต้อง [ERR-ID]';
}   



?>