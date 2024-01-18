<?php
session_start();
require('connect.php');
require('structure/numthai.php');
require_once __DIR__ . '/vendor/autoload.php';

//เงื่อนไข pj
if (!empty($_GET['id'])) {
  $idpj = mysqli_real_escape_string($con, $_GET['id']);
  $sql_ck_id = "SELECT * FROM `project` WHERE `id` = '$idpj' ";
  $result_ck_id = mysqli_query($con, $sql_ck_id);

  if (false === $result_ck_id) {
    die(mysqli_error($con));
  }

  $num_ck_id = mysqli_num_rows($result_ck_id);

  if ($num_ck_id == 0) {
    $msg = "ไม่พบเกียรติบัตรของท่าน [ERR-CER]";
    $_SESSION['msg_a'] = $msg;
    header("location:index.php");
  }
} else {
  $msg = "ไม่พบเกียรติบัตรของท่าน [ERR-CER]";
  $_SESSION['msg_a'] = $msg;
  header("location:index.php");
}


//เงื่อนไข learn
if (!empty($_GET['learn'])) {
  $idlearn = mysqli_real_escape_string($con, $_GET['learn']);
  $sql_ck_learn = "SELECT * FROM `user` WHERE `id`='$idlearn' AND idpj = '$idpj'";
  $result_ck_learn = mysqli_query($con, $sql_ck_learn);

  if (false === $result_ck_learn) {
    die(mysqli_error($con));
  }

  $num_ck_learn = mysqli_num_rows($result_ck_learn);

  if ($num_ck_learn == 0) {
    $msg = "ไม่พบเกียรติบัตรของท่าน [ERR-CER]";
    $_SESSION['msg_a'] = $msg;
    header("location:index.php");
  }
} else {
  $msg = "ไม่พบเกียรติบัตรของท่าน [ERR-CER]";
  $_SESSION['msg_a'] = $msg;
  header("location:index.php");
}

///////////////////////////////////////////////////////////////////////////

//รับ Tempate Img จาก idpj
if (isset($_GET['id'])) {
  $idpj = mysqli_real_escape_string($con, $_GET['id']);
  $sql_img = "SELECT `tempate` FROM `project` WHERE `id` = '$idpj' ";
  $result_img  = mysqli_query($con, $sql_img);

  if (false === $result_img) {
    die(mysqli_error($con));
  }

  while ($row_img = mysqli_fetch_assoc($result_img)) {
    $img_data = $row_img['tempate'];
    break;
  }
  if (empty($img_data)) {
    if (isset($_SESSION['username'])) {
      $msg = "กรุณาอัปโหลดเทมเพลต [ERR-TP-CER]";
      $_SESSION['msg_w'] = $msg;
      header("location:admin_pj.php?id=$idpj");
    } else {
      $msg = "เกียรติบัตรยังไม่เผยแพร่ [ERR-CER-PC]";
      $_SESSION['msg_a'] = $msg;
      header("location:index.php");
    }
  }
}


//รับชื่อโรงเรียน
$sql_nameschool = "SELECT `name` FROM `school`";
$result_nameschool = mysqli_query($con, $sql_nameschool);

if (false === $result_nameschool) {
  die(mysqli_error($con));
}

while ($row_name = mysqli_fetch_assoc($result_nameschool)) {
  $nameschool_data = $row_name['name'];
  break;
}

//รับชื่อฟอนต์
if (isset($_GET['id'])) {
  $idpj = mysqli_real_escape_string($con, $_GET['id']);
  $sql_font = "SELECT font FROM `project` WHERE id = '$idpj'";
  $result_font = mysqli_query($con, $sql_font);

  if (false === $result_font) {
    die(mysqli_error($con));
  }

  while ($row_font = mysqli_fetch_assoc($result_font)) {
    $font_db = $row_font['font'];
    break;
  }
}

//ประกาศ Var Path Img
$path = 'upload/tempate/';
$filename = $img_data;
$pathfile = $path . $filename;

//ประกาศ Var Qrcode
$qr = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];


// โหลด Liblary mPDF
$defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
$fontDirs = $defaultConfig['fontDir'];

$defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
$fontData = $defaultFontConfig['fontdata'];

$mpdf = new \Mpdf\Mpdf([
  'debug' => true,
  'format'            => 'A4',
  'mode'              => 'UTF-8',
  'fontDir' => array_merge($fontDirs, [
    __DIR__ . '/fonts',
  ]),
  'fontdata' => $fontData + [
    'thniramitas' => [
      'R' => 'THNiramit-AS.ttf',
      'B' => 'THNiramit-AS-Bold.ttf',
    ],
    'thsarabunnew' => [
      'R' => 'THSarabunNew.ttf',
      'B' => 'THSarabunNew-Bold.ttf',
    ]
  ],
  'default_font' => $font_db
]);


//กระดาษแนวนอน
$mpdf->AddPage('L');
$mpdf->adjustFontDescLineheight = 1;

//เริ่มเก็บ HTML
ob_start();
?>


<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <!-- Head Website-->
  <title>ระบบพิมพ์เกียรติบัตรออนไลน์ | <?php echo $nameschool_data ?> </title>
  <link rel="icon" href="img/fav.ico" type="image/x-icon" />
  <style>
    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
      margin: 0 !important;
      padding: 0 !important;
    }
  </style>
</head>

<body>

  <?php
  //รับ Data Form DB User
  if (isset($_GET['id'])) {
    $idpj = mysqli_real_escape_string($con, $_GET['id']);
    $sql_pj = "SELECT * FROM `project` WHERE `id` = '$idpj' ";
    $result_pj  = mysqli_query($con, $sql_pj);
  }
  if (false === $result_pj) {
    die(mysqli_error($con));
  }

  while ($row_pj = mysqli_fetch_assoc($result_pj)) {

    //รับ Data Form DB User
    if (isset($_GET['learn'])) {
      $idlearn = mysqli_real_escape_string($con, $_GET['learn']);
      $sql_learn = "SELECT * FROM `user` WHERE `id` = '$idlearn' ";
      $result_learn  = mysqli_query($con, $sql_learn);
    }
    if (false === $result_learn) {
      die(mysqli_error($con));
    }

    while ($row_learn = mysqli_fetch_assoc($result_learn)) {
  ?>

      <table>
        <tr>
          <td>
            <barcode class="bg-qrcode" code="<?= $qr ?>" type="QR" size="0.5" error="M" disableborder="1"> </barcode>
          </td>
          <td style="font-size: 20px"> <?php echo thainumDigit($row_learn['idcer']); ?> </td>
        </tr>
      </table>

      <div style="margin-top: <?= $row_pj['margin'] ?>; text-align: center;">
        <h1 style="font-size: <?= $row_pj['size_name'] ?>px; color: <?= $row_pj['color'] ?>;"><?= $row_learn['name'] ?><h1>

            <?php if ($row_pj['type'] == 1 && $row_learn['line2'] != '') { ?>
              <h2 style="font-size: <?= $row_pj['size_line2'] ?>px; color: <?= $row_pj['color'] ?>;"><?= $row_learn['line2'] ?><h2>
                <?php } elseif ($row_pj['type'] == 2) { ?>
                  <h2 style="font-size: <?= $row_pj['size_line2'] ?>px; color: <?= $row_pj['color'] ?>;"><?= $row_learn['line2'] ?><h2>
                      <h2 style="font-size: <?= $row_pj['size_line3'] ?>px; color: <?= $row_pj['color'] ?>;"><?= $row_learn['line3'] ?><h2>
                        <?php } ?>
      </div>



  <?php
      // ประกาศชื่อไฟล์
      $cername = "เกียรติบัตร " . $row_learn['name'] . " (" . $row_learn['idcer'] . ").pdf";
    }
  } ?>
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
exit;
?>