<?php
require('../../connect.php');

if(isset($_POST["name"]) && isset($_POST["shortname"])){

    $name = mysqli_real_escape_string($con,$_POST["name"]);
    $shortname = mysqli_real_escape_string($con,$_POST["shortname"]);
    $logo      = 'fav.ico';

    if(!empty($_FILES['logo']['tmp_name']))
    {
     move_uploaded_file($_FILES['logo']['tmp_name'], '../../img/'.$logo);
    }
    
    $sql = "UPDATE `school` SET `name` = '$name',  `shortname` = '$shortname'";
    $res_edit = mysqli_query($con,$sql);

    if (false === $res_edit) {
        die(mysqli_error($con));
    }

    mysqli_close($con);
}

else{
    echo 'ท่านเรียกใช้งานไม่ถูกต้อง [ERROR]';
}   


?>