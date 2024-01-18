<?php
//Get Name School
require_once('connect.php');
$sql_nameschool = "SELECT `name` FROM `school`";
$result_nameschool = mysqli_query($con, $sql_nameschool) or die(mysqli_error($con));
$nameschool_data = mysqli_fetch_assoc($result_nameschool)['name'];
?>

<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<title>ระบบพิมพ์เกียรติบัตรออนไลน์ - <?= $nameschool_data ?></title>
<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
<link rel="icon" href="img/fav.ico" type="image/x-icon" />
<link href='assets/css/main.css' rel='stylesheet' type='text/css'>

<!-- Fonts and icons -->
<script src="assets/js/plugin/webfont/webfont.min.js"></script>

<script>
	WebFont.load({
		custom: {
			"families": ["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"],
			urls: ['assets/css/fonts.min.css']
		},
		active: function() {
			sessionStorage.fonts = true;
		}
	});
</script>

<!-- CSS Files -->
<link rel="stylesheet" href="assets/css/bootstrap.min.css">
<link rel="stylesheet" href="assets/css/atlantis.min.css">

<!-- CSS DT -->
<link rel="stylesheet" href="css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="css/responsive.bootstrap4.min.css">

<!-- BS Color -->
<link rel="stylesheet" href="css/bootstrap-colorpicker.min.css">