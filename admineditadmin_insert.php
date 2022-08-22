<?php

require('connect.php');

$sql = "SELECT * FROM `admin` WHERE `id` = ".$_POST["id"];
$rs = mysqli_query($con,$sql);

if (false === $rs) {
    die(mysqli_error($con));
}

while($row = mysqli_fetch_array($rs,MYSQLI_ASSOC)){
    $arr[] = $row;
}

echo json_encode($arr);

mysqli_free_result($rs);
mysqli_close($con);

?>
