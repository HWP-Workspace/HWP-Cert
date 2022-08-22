<?php
require('connect.php');
if(isset($_SESSION['username'])){
	header('location: admin.php');
}

//เงื่อนไข pj
if(!empty($_GET['id'])){
    $idpj = mysqli_real_escape_string($con, $_GET['id']);
    $sql_pj = "SELECT * FROM `project` WHERE `id` = '$idpj' ";
    $result_pj = mysqli_query($con,$sql_pj);
    
    if (false === $result_pj) {
        die(mysqli_error($con));
      }
  
    $num_pj = mysqli_num_rows($result_pj); 
  
    if($num_pj == 0){
        header("location:index.php");
      }

  
    }
    else{
      header("location:index.php");
    }


//เงื่อนไข learn

if(!empty($_GET['learn'])){
    $idlearn = mysqli_real_escape_string($con, $_GET['learn']);
    $sql_learn = "SELECT * FROM `user` WHERE `id`=".$idlearn ;
    $result_learn = mysqli_query($con,$sql_learn); 

    if (false === $result_learn) {
        die(mysqli_error($con));
      }
  
    $num_learn = mysqli_num_rows($result_learn); 
  
    if($num_learn == 0){
        header("location:index.php");
      }
  
  
}
    else{
      header("location:index.php");
}




require('structure/numthai.php');
require_once __DIR__ . '/vendor/autoload.php';


//รับ Tempate Img จาก idpj
if(isset($_GET['id'])){
    $idpj = mysqli_real_escape_string($con, $_GET['id']);
    $sql_img = "SELECT `tempate` FROM `project` WHERE `id` = '$idpj' ";
    $result_img  = mysqli_query($con,$sql_img ); 

    if (false === $result_img) {
        die(mysqli_error($con));
    }

        while ($row_img = mysqli_fetch_assoc($result_img)) {
                   $img_data = $row_img['tempate'];
                   break;                  
  }
  
}


//รับชื่อโรงเรียน
$sql_nameschool = "SELECT `name` FROM `school`";
$result_nameschool = mysqli_query($con,$sql_nameschool); 

if (false === $result_nameschool) {
    die(mysqli_error($con));
}

    while ($row_name = mysqli_fetch_assoc($result_nameschool)) {
        $nameschool_data = $row_name['name'];
         break;
}


//ดึงชื่อผู้เข้าร่วม
if(isset($_GET['learn'])){
  $idlearn = mysqli_real_escape_string($con, $_GET['learn']);
  $sql_namelearn = "SELECT `name` FROM `user` WHERE `id`=".$idlearn ;
  $result_namelearn = mysqli_query($con,$sql_namelearn); 

  if (false === $result_namelearn) {
    die(mysqli_error($con));
}

      while ($row_namelearn = mysqli_fetch_assoc($result_namelearn)) {
                 $namelearn_data = $row_namelearn['name'];
                 break;
      }
}

//ดึง line2
if(isset($_GET['learn'])){
    $idlearn = mysqli_real_escape_string($con, $_GET['learn']);
    $sql_line2learn = "SELECT `line2` FROM `user` WHERE `id`=".$idlearn ;
    $result_line2learn = mysqli_query($con,$sql_line2learn); 

    if (false === $result_line2learn) {
        die(mysqli_error($con));
    }

        while ($row_line2 = mysqli_fetch_assoc($result_line2learn)) {
                   $line2learn_data = $row_line2['line2'];
                   break;
        }
}

//ดึง line3
if(isset($_GET['learn'])){
    $idlearn = mysqli_real_escape_string($con, $_GET['learn']);
    $sql_line3learn = "SELECT `line3` FROM `user` WHERE `id`=".$idlearn ;
    $result_line3learn = mysqli_query($con,$sql_line3learn); 

    if (false === $result_line3learn) {
        die(mysqli_error($con));
    }

        while ($row_line3learn = mysqli_fetch_assoc($result_line3learn)) {
                   $line3learn_data = $row_line3learn['line3'];
                   break;
        }
}
  
  

//รับค่า Type
if(isset($_GET['id'])){
    $idpj = mysqli_real_escape_string($con, $_GET['id']);
    $query_type = "SELECT `type` FROM `project` WHERE `id` = $idpj"; 
    $result_type = mysqli_query($con,$query_type); 

    if (false === $result_type) {
        die(mysqli_error($con));
    }

    while ($row_type = mysqli_fetch_assoc($result_type)) {
            $type_data = $row_type['type'];
            break;
    }
}

//รับค่า idcer
if(isset($_GET['learn'])){
    $idlearn = mysqli_real_escape_string($con, $_GET['learn']);
    $query_idcer = "SELECT `idcer` FROM `user` WHERE `id` = $idlearn"; 
    $result_idcer = mysqli_query($con,$query_idcer); 

    if (false === $result_idcer) {
        die(mysqli_error($con));
    }

    while ($row_idcer = mysqli_fetch_assoc($result_idcer)) {
            $idcer_data = $row_idcer['idcer'];
            break;
    }
}

//ประกาศ Var Path Img
$path = 'upload/tempate/' ;
$filename = $img_data ;
$pathfile = $path.$filename ;

//แปลงเลขไทย
$idcerthai = thainumDigit($idcer_data);

//ประกาศ Var Qrcode
$qr = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

// โหลด Liblary mPDF
$mpdf = new \Mpdf\Mpdf( [
    'format'            => 'A4',
    'mode'              => 'utf-8',
    'default_font'      => 'sarabun',
    'default_font_size' => '16',
    'tempDir'           => '/tmp',
 ] );

//กระดาษแนวนอน
$mpdf->AddPage('L'); 

//ชื่อไฟล์
$cername = 'เกียรติบัตร '.$namelearn_data.'.pdf';

//เริ่มเก็บ HTML
ob_start(); 
?>


<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
    <!-- Head Website-->
    <title>ระบบพิมพ์เกียรติบัตรออนไลน์ | <?php echo $nameschool_data ?> </title>
    <link href="css/print.css" rel="stylesheet">
    
</head>
<body>

<table>
  <tr>
    <td > <barcode class="bg-qrcode" code="<?=$qr?>" type="QR" size="0.5" error="M" disableborder = "1"> </barcode> </td>
    <td> <?php echo $idcerthai ; ?> </td>
  </tr>
</table>






    <?php
    // ถ้า Type = 0
    if($type_data == 0){
    echo '<div class="name-0">
    <b> '.$namelearn_data.' </b>
    </div>';
    }

    // ถ้า Type = 1
    if($type_data == 1){

        if(!empty($line2learn_data)){
        echo'
        <div class="name-1">
        <b> '.$namelearn_data.' </b>
        </div>

        <div class="line2-1">
        <b> '.$line2learn_data.' </b>
        </div>';
        }

        else{
        echo '<div class="name-0">
        <b> '.$namelearn_data.' </b>
        </div>';
        }

    }


    // ถ้า Type = 2
    if($type_data == 2){
        if(!empty($line2learn_data) && !empty($line3learn_data) ){
            echo'
            <div class="name-2">
            <b> '.$namelearn_data.' </b>
            </div>
        
            <div class="line2-2">
            <b> '.$line2learn_data.' </b>
            </div>

            <div class="line3-2">
            <b> '.$line3learn_data.' </b>
            </div>';
        }
        
        elseif(!empty($line2learn_data) ){
            echo'
            <div class="name-1">
            <b> '.$namelearn_data.' </b>
            </div>
        
            <div class="line2-1">
            <b> '.$line2learn_data.' </b>
            </div>
            ';
        }    

        elseif(!empty($line3learn_data) ){
            echo'
            <div class="name-1">
            <b> '.$namelearn_data.' </b>
            </div>
        
            <div class="line2-1">
            <b> '.$line3learn_data.' </b>
            </div>
            ';
        }  

        else{
        echo '<div class="name-0">
        <b> '.$namelearn_data.' </b>
        </div>';
        }
        
    }
    ?>

</body>
</html>


<?php
//รับค่า HTML
$html = ob_get_contents();
$html = ob_get_clean();
//Set Background 
$mpdf->SetDefaultBodyCSS('background', "url('$pathfile')");
$mpdf->SetDefaultBodyCSS('background-image-resize', 6);

$mpdf->WriteHTML($html);
$mpdf->Output($cername, 'I');
ob_end_flush();
?>
