<?php
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set('Asia/Bangkok');

$host="localhost";
$user="root";
$passwd="";
$db="cer";

$con = new mysqli($host,$user,$passwd,$db);
if($con->connect_error){
    die("Connection Failed :" .$con->connect_error);
}

$con->set_charset("utf8");

//Secert Key For JWT
$key = ':8_2aTa}7D+B&~7NFo;lNmq9nqs4=;vX6X0N^6£z53u(hFV!I9';
?>