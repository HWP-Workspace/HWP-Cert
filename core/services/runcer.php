<?php
//รับชื่อย่อโรงเรียน
$sql_shortnameschool = "SELECT `shortname` FROM `school`";
$result_shortnameschool = mysqli_query($con,$sql_shortnameschool); 
    while ($row_shortnameschool = mysqli_fetch_assoc($result_shortnameschool)) {
               $shortnameschool_data = $row_shortnameschool['shortname'];
               break;
}

//รับรหัสกลุ่มสาระ
$sql_ckdp = "SELECT `iddp` FROM `project` WHERE id = '$id'";
$result_ckdp = mysqli_query($con,$sql_ckdp); 
    while ($row_ckdp = mysqli_fetch_assoc($result_ckdp)) {
               $ckdp_data = $row_ckdp['iddp'];
               break;
}

//รับรหัสย่อกลุ่มสาระ
$sql_cksdp = "SELECT `shortdp` FROM `dp` WHERE id = '$ckdp_data'";
$result_cksdp = mysqli_query($con,$sql_cksdp); 
    while ($row_cksdp = mysqli_fetch_assoc($result_cksdp)) {
               $cksdp_data = $row_cksdp['shortdp'];
               break;
}

// วันที่โปรเจค
$sql_year = "SELECT `date` FROM `project` WHERE `id`=".$id ;
$result_year = mysqli_query($con, $sql_year) ;
while ($row_year = mysqli_fetch_assoc($result_year)) {
  $year = date("Y", strtotime($row_year['date']));
  $yearthai = $year+543;
break;
}

//นับจำนวน Cer
$sql_totalcer = mysqli_query($con ,"SELECT COUNT(*) FROM `user` WHERE `idpj`=".$id);
$res = mysqli_fetch_array($sql_totalcer);
$records_cer = (int)$res[0];
$int_cer = (int)$records_cer;

// รวมเลข Cer
$idcer = $shortnameschool_data.".".$cksdp_data.".".$yearthai.".".$id."/".$int_cer;

//เช็คมีซ้ำไหมก่อน
$cer_check_query = "SELECT * FROM `user` WHERE `idcer` = '$idcer' LIMIT 1";
$query_cer = mysqli_query($con, $cer_check_query);
$result_cer = mysqli_fetch_assoc($query_cer);


//ถ้าซ้ำจะข้ามเลข
if($result_cer){
$idcer = $shortnameschool_data.".".$yearthai.".".$id."/".$int_cer+=1 ;
$sql_runcer = "UPDATE `user` SET `idcer` = '$idcer' WHERE `id`=".$idlearn;
$result_runcer = mysqli_query($con,$sql_runcer);  
}

//ถ้าไม่
$sql_runcer = "UPDATE `user` SET `idcer` = '$idcer' WHERE `id`=".$idlearn;
$result_runcer = mysqli_query($con,$sql_runcer); 




?>