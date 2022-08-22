<?php
require('../../connect.php');

if (isset($_POST['function']) && $_POST['function'] == 'name') {
	$sql = "SELECT * FROM `school`";
    $query3 = mysqli_query($con, $sql);
    $result = mysqli_fetch_assoc($query3);
    echo $result['name'];
}


if (isset($_POST['function']) && $_POST['function'] == 'shortname') {
	$sql = "SELECT * FROM `school`";
    $query2 = mysqli_query($con, $sql);
    $result = mysqli_fetch_assoc($query2);
    echo $result['shortname'];
}

?>
