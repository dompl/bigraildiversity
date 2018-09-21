<?php
/* Load classes with composer () */
if (file_exists(dirname(__FILE__) . '/vendor/autoload.php')) {
  require_once dirname(__FILE__) . '/vendor/autoload.php';
}
//use mobiledetect\mobiledetectlib;
//$detect = new Mobile_Detect;
// Initiate theme config
if (class_exists('config\\init')) {
  new \config\init();
}
// Initiate theme files
if (class_exists('theme\\init')) {
  new \theme\init();
}