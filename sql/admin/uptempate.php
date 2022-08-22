<meta charset="UTF-8">
<?php
session_start();

//1. เชื่อมต่อ database: 
require('../../connect.php');  //ไฟล์เชื่อมต่อกับ database ที่เราได้สร้างไว้ก่อนหน้าน้ี
$fileupload = (isset($_POST['upload']) ? $_POST['upload'] : '');//รับค่าไฟล์จากฟอร์ม	

//รับค่า idpj. 
$id = mysqli_real_escape_string($con,$_POST["id"]);


//เพิ่มไฟล์
$upload=$_FILES['upload'];
if($upload != '') {   //not select file
    //โฟลเดอร์ที่จะ upload file เข้าไป 
    $path="../../upload/tempate/";  

    //เอาชื่อไฟล์เก่าออกให้เหลือแต่นามสกุล
    $type = strrchr($_FILES['upload']['name'],".");
        
    //ตั้งชื่อไฟล์ใหม่โดยเอาเวลาไว้หน้าชื่อไฟล์เดิม
    $newname = "cert_pj-".$id.$type;
    $path_copy=$path.$newname;
    $path_link="../../upload/tempate/".$newname;

//คัดลอกไฟล์ไปเก็บที่เว็บเซริ์ฟเวอร์
move_uploaded_file($_FILES['upload']['tmp_name'],$path_copy);  	
	}

	// เพิ่มไฟล์เข้าไปในตาราง uploadfile
		$sql = "UPDATE `project` SET `tempate` = '$newname' WHERE `id` = ".$id;
		
		$result = mysqli_query($con, $sql) or die ("Error in query: $sql " . mysqli_error());
	
	mysqli_close($con);
	// javascript แสดงการ upload file
    
	if($result){
		$msg = "อัปโหลดสำเร็จ [SUCCESS]";
		$_SESSION['msg_s'] = $msg;
		header("Location: ../../admin_pj.php?id=$id");
	}
	else{
		$msg = "พบข้อผิดพลาด กรุณาติดต่อผู้ดูแลระบบ [ERR-Q-IMP]";
		$_SESSION['msg_w'] = $msg;
		header("Location: ../../admin_pj.php?id=$id");
}
?>