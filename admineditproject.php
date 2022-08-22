<?php
require('connect.php');

if(isset($_POST["name"]) && isset($_POST["date"]) && isset($_POST["type"])){

    $name = mysqli_real_escape_string($con,$_POST["name"]);
    $date = mysqli_real_escape_string($con,$_POST["date"]);
    $type = mysqli_real_escape_string($con,$_POST["type"]);

    $sql = "UPDATE `project` SET `name` = '$name', `date` = '$date', `type` = '$type' WHERE `id` = ".$_POST["id"];

    $res = mysqli_query($con,$sql);

    if (false === $res) {
        die(mysqli_error($con));
    }

    mysqli_close($con);

}

else{
    echo 'error';
}

?>