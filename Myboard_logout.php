<?php
session_start();
session_unset();    
session_destroy(); 
header("Location: Myboard_login.php"); 
exit;
?>
