<?php
require("core/services/function.php");
session_start();

if(isset($_SESSION['token'])){
    $jwt = decodeJWT($_SESSION["token"]);
    if (!$jwt) {
        header("Location: logout");
    } else { 
        $now = strtotime(date("Y-m-d H:i:s"));
        $exp = strtotime($jwt['exp_date']);
        if ($now > $exp) {
            header("Location: logout");
        }else{
            //Decode JWT
            $jwt = decodeJWT($_SESSION["token"]);
        }
    }
}   
?>