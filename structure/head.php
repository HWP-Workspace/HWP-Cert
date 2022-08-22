<?php
//รับชื่อโรงเรียน
require('connect.php');
  $sql_nameschool = "SELECT `name` FROM `school`";
  $result_nameschool = mysqli_query($con,$sql_nameschool); 
      while ($row_name = mysqli_fetch_assoc($result_nameschool)) {
                 $nameschool_data = $row_name['name'];
                 break;
}

?>

<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ระบบพิมพ์เกียรติบัตรออนไลน์ | <?php echo $nameschool_data ?> </title>
    <link rel="icon" href="img/fav.ico" type="image/x-icon"/>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <!-- Google Font -->	
    <link href='https://fonts.googleapis.com/css?family=Sarabun' rel='stylesheet' type='text/css'>

    <awsome>
    <!-- Awesome Font -->
    <script src="https://kit.fontawesome.com/d662a0dcd0.js" crossorigin="anonymous"></script>
    <!-- Css -->
    <link href="css/main.css" rel="stylesheet">
    <!-- Table -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap5.min.css">
    <!-- DataTable Responsive-->  
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/fixedheader/3.1.8/css/fixedHeader.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.7/css/responsive.bootstrap.min.css">
    