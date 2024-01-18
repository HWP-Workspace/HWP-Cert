<?php
require('../../connect.php');

//ลบ project
if(isset($_POST["id"])){
    $sql = "DELETE FROM `admin` WHERE `id` = ".$_POST["id"];
     $res = mysqli_query($con,$sql);
    if (false === $res) {
        die(mysqli_error($con));
    }
}


?>
