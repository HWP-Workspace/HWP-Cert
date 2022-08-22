<?php
require('../../connect.php');

if(isset($_POST['function']) && $_POST['function'] == 'project'){
$sql = "SELECT * FROM project";
$query = $con->query($sql);
$count_pj = mysqli_num_rows($query);
echo json_encode($count_pj);
}

if(isset($_POST['function']) && $_POST['function'] == 'user'){
    $sql = "SELECT * FROM user";
    $query = $con->query($sql);
    $count_user = mysqli_num_rows($query);
    echo json_encode($count_user);
}

if(isset($_POST['function']) && $_POST['function'] == 'admin'){
    $sql = "SELECT * FROM admin";
    $query = $con->query($sql);
    $count_admin = mysqli_num_rows($query);
    echo json_encode($count_admin);
}
?>