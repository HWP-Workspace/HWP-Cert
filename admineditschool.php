<?php
require('connect.php');

if(isset($_POST["name"])  && isset($_POST["shortname"])){

    $name = mysqli_real_escape_string($con,$_POST["name"]);
    $shortname = mysqli_real_escape_string($con,$_POST["shortname"]);

    $sql = "UPDATE `school` SET `name` = '$name', `shortname` = '$shortname' WHERE `id` = ".$_POST["id"];

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