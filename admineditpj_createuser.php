<?php
session_start();
require('connect.php');

//รับค่า Type
$id = mysqli_real_escape_string($con,$_POST["id"]);
$query_type = "SELECT `type` FROM `project` WHERE `id` =".$id; 
$result_type = mysqli_query($con,$query_type);

if (false === $result_type) {
    die(mysqli_error($con));
}

while ($row_type = mysqli_fetch_assoc($result_type)) {
           $type_data = $row_type['type'];
           break;
}



if($type_data == 0){
    if ((isset($_POST["id"]) && isset($_POST["name"])) ){

    $id = mysqli_real_escape_string($con,$_POST["id"]);
    $name = mysqli_real_escape_string($con,$_POST["name"]);

    $sql = "INSERT INTO `user`(`name`,`idpj`,`line2`,`line3`,`idcer`) values('$name','$id','','','')";

    $res_name = mysqli_query($con,$sql);
    if (false === $res_name) {
        die(mysqli_error($con));
    }

    $idlearn = mysqli_insert_id($con);
    require('structure/runcer.php');

    mysqli_close($con);

    echo "<script>"; 
            // คำสั่ง replace - java
    echo "alert('เพิ่มผู้เข้าร่วมโครงการ/กิจกรรม สำเร็จ!');" ;
    echo "location.replace('admin_editpj.php?id=$id');";
    echo "</script>";
    }

}

if($type_data == 1){
    if( (isset($_POST["id"]) && isset($_POST["name"]) && isset($_POST["line2"])) ){
    
    $id = mysqli_real_escape_string($con,$_POST["id"]);
    $name = mysqli_real_escape_string($con,$_POST["name"]);
    $line2 = mysqli_real_escape_string($con,$_POST["line2"]);

    $sql = "INSERT INTO `user`(`name`,`idpj`,`line2`,`line3`,`idcer`) values('$name','$id','$line2','','')";

    $res_line2 = mysqli_query($con,$sql);
    if (false === $res_name) {
        die(mysqli_error($con));
    }

    $idlearn = mysqli_insert_id($con);
    require('structure/runcer.php');

    mysqli_close($con);

    echo "<script>"; 
            // คำสั่ง replace - java
    echo "alert('เพิ่มผู้เข้าร่วมโครงการ/กิจกรรม สำเร็จ!');" ;
    echo "location.replace('admin_editpj.php?id=$id');";
    echo "</script>";
    }

}

if($type_data == 2){
    if( (isset($_POST["id"]) && isset($_POST["name"]) && isset($_POST["line2"]) && isset($_POST["line3"])) ){
    
    $id = mysqli_real_escape_string($con,$_POST["id"]);
    $name = mysqli_real_escape_string($con,$_POST["name"]);
    $line2 = mysqli_real_escape_string($con,$_POST["line2"]);
    $line3 = mysqli_real_escape_string($con,$_POST["line3"]);

    $sql = "INSERT INTO `user`(`name`,`idpj`,`line2`,`line3`,`idcer`) values('$name','$id','$line2','$line3','')";

    $res_line3 = mysqli_query($con,$sql);
    if (false === $res_line3) {
        die(mysqli_error($con));
    }

    $idlearn = mysqli_insert_id($con);
    require('structure/runcer.php');

    mysqli_close($con);

    echo "<script>"; 
            // คำสั่ง replace - java
    echo "alert('เพิ่มผู้เข้าร่วมโครงการ/กิจกรรม สำเร็จ!');" ;
    echo "location.replace('admin_editpj.php?id=$id');";
    echo "</script>";
    }

}

?>
