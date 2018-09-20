<?php

//Define root folder
define ('FOLDER_ROOT', __DIR__);
// Define CSS folder using root folder constant above
define ('FOLDER_CSS', FOLDER_ROOT.'/css/');
define ('FOLDER_JS', FOLDER_ROOT.'/js/');
define ('FOLDER_Template', FOLDER_ROOT.'/template/');
define ('FOLDER_Core', FOLDER_ROOT.'/core/');

define ('Employee', FOLDER_ROOT.'/application/employee/');

$global = new stdClass();
$global->wwwroot = "http://" . $_SERVER['SERVER_NAME'] . "/IMS/"; // web root
$global->secroot = "https://" . $_SERVER['SERVER_NAME'] . "/IMS/"; // web root
$global->dirroot = $_SERVER['DOCUMENT_ROOT'] . "/IMS/"; // directory root
$global->upload_url = $global->wwwroot . "uploads/";
$global->relpath = "/IMS/"; // relative path

define("WWWROOT", $global->wwwroot);


?>

