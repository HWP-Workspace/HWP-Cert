<meta charset="UTF-8">
<?php
session_start();

//1. เชื่อมต่อ database: 
require('../../connect.php');  //ไฟล์เชื่อมต่อกับ database ที่เราได้สร้างไว้ก่อนหน้าน้ี
if(!isset($_POST['upload'])){

//รับค่า idpj. 
$id = mysqli_real_escape_string($con,$_POST["id"]);

//เพิ่มไฟล์
$upload = $_FILES['upload'];
if($upload != '') {   //not select file
    //โฟลเดอร์ที่จะ upload file เข้าไป 
    $path = "../../upload/tempate/";  

    //เอาชื่อไฟล์เก่าออกให้เหลือแต่นามสกุล
    $type = strrchr($_FILES['upload']['name'],".");
        
    //ตั้งชื่อไฟล์ใหม่โดยเอาเวลาไว้หน้าชื่อไฟล์เดิม
    $newname = "cert_pj-".$id.$type;
    $path_copy = $path.$newname;

	/////////////////////////////////////////////////////////////////////

	include "../../structure/resize.php"; //นำเข้า class ResizeImage เข้ามาใช้ในไฟล์
	$path_p = "../../upload/preview/";  
	$preview = 'preview_'.$newname;
	$newFileThumbnail = $path_p.$preview;//เปลี่ยนชื่อไฟล์ thumbnail ที่ ลดขนาดแล้ว

		if (move_uploaded_file($_FILES["upload"]["tmp_name"], $path_copy)) { //คัดลอกไฟล์ไปเก็บที่เว็บเซริ์ฟเวอร์
			
			$resize = new ResizeImage($path_copy);//เรียกใช้งาน class สำหรับ Resize
			$resize->resizeTo(400, 283, 'exact');//กำหนดขนาดที่ต้องการ Resize
			$resize->saveImage($newFileThumbnail);//สร้างไฟล์ที่ลดขนาดแล้ว
	    }
  
	// เพิ่มไฟล์เข้าไปในตาราง uploadfile
		$sql = "UPDATE `project` SET `tempate` = '$newname', `preview` = '$preview' WHERE `id` = ".$id;
		
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

	}
}
?>