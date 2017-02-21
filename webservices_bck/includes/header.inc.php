<?php

/* Includes config,db and table definitions and common functions files */	
include($_SERVER['DOCUMENT_ROOT'].'/main-config.php');

define("DB_SERVER",DB_HOST);	
define("DB_USER",DB_USERNAME);
define("DB_PASSWORD",DB_PASSWORD);
define("DB_NAME",DB_NAME);

define("TOKEN_SECRET_KEY", "QezyplayIB");


define("SITE_URL", URL_SITE);
define("SITE_NAME", URL_SITE);


/* Include db & data files */
require_once("common_functions.php");
require_once("classes/dbconfig.class.php");  //DB connection
require_once("classes/servicedata.class.php");


?>
