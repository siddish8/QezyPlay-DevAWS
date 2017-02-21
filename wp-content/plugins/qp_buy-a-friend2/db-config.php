<?php

//include('./main-config.php');
if ((include $_SERVER['DOCUMENT_ROOT'].'/main-config.php') == TRUE) {
   // echo 'OK.dirfile';
}

ob_start();

session_start(); 

$site=SERVER; //dev change this only
define("ENV", "live");  //dev (or) live
define("ADMIN_EMAIL", "admin@qezyplay.com");


