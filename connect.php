<?php
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set('Asia/Bangkok');
$host="localhost";
$user="root";
$passwd="";
$db="cert";
$con = new mysqli($host,$user,$passwd,$db);
if($con->connect_error){
    die("Connection Failed :" .$con->connect_error);
}
$con->set_charset("utf8");

?>