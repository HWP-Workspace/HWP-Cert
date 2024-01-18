<?php
require('../connect.php');
if(isset($_GET['name']) && isset($_GET['path'])){
    $path = mysqli_real_escape_string($con ,$_GET['path']);
    $name = mysqli_real_escape_string($con, $_GET['name']);

    if($path == "cer"){
        $file = "../upload/tempate/".$name;
    }else{

    }

    $filename = basename($file);
    $file_extension = strtolower(substr(strrchr($filename,"."),1));
    
    switch( $file_extension ) {
        case "gif": $ctype="image/gif"; break;
        case "png": $ctype="image/png"; break;
        case "jpeg":
        case "jpg": $ctype="image/jpeg"; break;
        case "svg": $ctype="image/svg+xml"; break;
        default:
    }
    header('Content-type: ' . $ctype);
    readfile($file);
}else{
    echo "ท่านเรียกใช้งานไม่ถูกต้อง";
}
?>