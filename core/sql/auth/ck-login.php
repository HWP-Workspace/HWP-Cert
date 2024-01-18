<?php
session_start();
require('../../../connect.php');
include_once('../../../vendor/autoload.php');
use Firebase\JWT\JWT;

if (isset($_POST['username']) && isset($_POST['password'])) {
  $username = mysqli_real_escape_string($con, $_POST['username']);
  $password = mysqli_real_escape_string($con, $_POST['password']);
  $password = md5($password); // แปลงรหัส md5

  $query = "SELECT `username`, `name`, iddp  FROM `admin` WHERE `username` = '$username' AND `password` ='$password'";
  $result = mysqli_query($con, $query) or die(mysqli_error($con));

  if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);
    $payload = [
      'username' => $row['username'],
      'name' => $row['name'],
      'iddp' => $row['iddp'],
      'iat' => time(),
      'exp' => time() + (60 * 60 * 24 * 30)
    ];
    $jwt = JWT::encode($payload, $key, 'HS256');
    $_SESSION['token'] = $jwt;
    echo "S";
  } else {
    echo "ชื่อผู้ใช้ หรือ รหัสผ่านไม่ถูกต้อง [ERR-CK-LOGIN]";
  }
} else {
  echo 'ท่านเรียกใช้งานไม่ถูกต้อง [ERROR]';
}
