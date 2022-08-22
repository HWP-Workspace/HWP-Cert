<?php
session_start();
session_destroy();
echo '<script>';
echo 'alert(\'ออกจากระบบเรียบร้อยแล้ว !\');';
echo '</script>';
header("Location: index.php ");	
?>