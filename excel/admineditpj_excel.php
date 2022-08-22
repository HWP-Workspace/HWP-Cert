<?php
require('../connect.php');
require_once('php-excel-reader/excel_reader2.php');
require_once('SpreadsheetReader.php');

//รับค่า idpj. 
$id = mysqli_real_escape_string($con,$_POST["id"]);

//รับค่า Type
$query_type = "SELECT `type` FROM `project` WHERE `id` =".$id; 
$result_type = mysqli_query($con,$query_type); 
while ($row_type = mysqli_fetch_assoc($result_type)) {
           $type_data = $row_type['type'];
           break;
}

//รับโรงเรียน
$sql_nameschool = "SELECT `name` FROM `school`";
$result_nameschool = mysqli_query($con,$sql_nameschool); 
      while ($row_name = mysqli_fetch_assoc($result_nameschool)) {
                 $nameschool_data = $row_name['name'];
                 break;
}

if (isset($_POST["import"]))
{
       
  $allowedFileType = ['application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
  
  if(in_array($_FILES["file"]["type"],$allowedFileType)){

       $targetPath = 'uploads/'.$_FILES['file']['name'];
       move_uploaded_file($_FILES['file']['tmp_name'], $targetPath);
        
        $Reader = new SpreadsheetReader($targetPath);
        
        $sheetCount = count($Reader->sheets());
        
        for($i=0;$i<$sheetCount;$i++)
        {
            $Reader->ChangeSheet($i);

            $k = 0; // กำหนดค่า K 

            foreach ($Reader as $Row)
            {
                $k++; // กำหนดค่า K ++
                if ($k>1){ // กำหนดค่า K เพื่อไม่ดำเนินการบรรทัด 1

                    if($type_data == 0){
                        $name = "";//ฟิว 1
                        if(isset($Row[0])) {
                            $name = mysqli_real_escape_string($con,$Row[0]);
                        }//ฟิว 1
                    }    

                    if($type_data == 1){
                        $name = "";//ฟิว 1
                        if(isset($Row[0])) {
                            $name = mysqli_real_escape_string($con,$Row[0]);
                        }//ฟิว 1
                        
                        $line2 = "";//ฟิว 2
                        if(isset($Row[1])) {
                            $line2 = mysqli_real_escape_string($con,$Row[1]);
                        }//ฟิว 2

                    }    

                    if($type_data == 2){
                        $name = "";//ฟิว 1
                        if(isset($Row[0])) {
                            $name = mysqli_real_escape_string($con,$Row[0]);
                        }//ฟิว 1

                        $line2 = "";//ฟิว 2
                        if(isset($Row[1])) {
                            $line2 = mysqli_real_escape_string($con,$Row[1]);
                        }//ฟิว 2

                        $line3 = "";//ฟิว 3
                        if(isset($Row[2])) {
                            $line3 = mysqli_real_escape_string($con,$Row[2]);
                        }//ฟิว 3

                    }    

                }

                if (!empty($name)) {
                    if($type_data == 0){
                        $query = "INSERT INTO `user`
                                (`idpj`, `name`, `line2`, `line3`, `idcer`) 
                                values('".$id."', '".$name."', '', '', '')";
                        $result = mysqli_query($con, $query);

                        if (false === $result) {
                            die(mysqli_error($con));
                        }

                        $idlearn = mysqli_insert_id($con);
                        require('../structure/runcer.php');
                    }

                    elseif($type_data == 1){
                        $query = "INSERT INTO `user`
                                (`idpj`, `name`, `line2`, `line3`, `idcer`) 
                                values('".$id."','".$name."','".$line2."', '', '')";
                        $result = mysqli_query($con, $query);

                        if (false === $result) {
                            die(mysqli_error($con));
                        }

                        $idlearn = mysqli_insert_id($con);
                        require('../structure/runcer.php');
                    }

                    elseif($type_data == 2){
                        $query = "INSERT INTO `user`
                                (`idpj`, `name`, `line2`, `line3`, `idcer`) 
                                values('".$id."','".$name."','".$line2."','".$line3."', '')";
                        $result = mysqli_query($con, $query);

                        if (false === $result) {
                            die(mysqli_error($con));
                        }
                        
                        $idlearn = mysqli_insert_id($con);
                        require('../structure/runcer.php');
                    }

                    if (! empty($result)) {
                      $type = "success";
                      $message = "Excel Data Imported into the Database";
                      echo "<script>";
                      echo"alert('สำเร็จ! ข้อมูลถูกเพิ่มลงฐานข้อมูล');";
                      echo "location.replace('../admin_editpj.php?id=$id');";
                      echo "</script>";
                    
                        

                    } else {
                        $type = "error";
                        $message = "Problem in Importing Excel Data";
                        echo "<script>";
                        echo "alert('ผิดพลาด! พบปัญหาในการนำเข้าไฟล์')";
                        echo "location.replace('../admin_editpj.php?id=$id');";
                        echo "</script>";
                    }
                }
             }
        
         }
  }
  else
  { 
        $type = "error";
        $message = "Invalid File Type. Upload Excel File.";
        echo "<script>";
        echo"alert('ไม่สามารถอัปโหลดได้ กรุณาอัปโหลดไฟล์ Excel เท่านั้น');";
        echo"location.replace ='../admin_editpj.php?id=$id';";
        echo "</script>";
  }
unlink($targetPath);  
}
?>