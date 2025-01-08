<?php 
error_reporting(E_ALL & ~E_NOTICE);
ini_set('display_errors',1);

session_start();
session_unset();
session_destroy();

$past = time() - 100; 

setcookie("ID_my_site", "", $past, "/"); 

setcookie("Key_my_site", "", $past, "/"); 

header("Location: sakumlapa.php");

?> 