<?php

ini_set("display_errors",true);
date_default_timezone_set("Europe/London");
define("DB", "mysql:host=localhost;dbname=cms");
define("DB_USER", "root");
define("DB_PASS", "0000");
define("CLASS_PATH", "classes");
define("TEMPLATE_PATH","templates");
define("HOMEPAGE_NUM_ARTICLES", 5);
define("ADMIN_USER", "admin");
define("ADMIN_PASS", "password123");
require(CLASS_PATH . "/Article.php");

function handleException($exc){
  echo "Sorry, a problem occurred. Please try again later.";
  error_log($exc->getMessage());
}

set_exception_handler('handleException');

 ?>
