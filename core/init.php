<?php 
ob_start(); // Added to avoid a common error of 'header already sent' (not discussed in the tutorial)
session_start();


require_once 'Session_function.php';
require_once 'connect/database.php';
require_once 'connect/databaseCRUD.php';

require_once 'classes/general.php';
require_once 'classes/users.php';

require_once 'classes/category.php';
require_once 'classes/employee.php';
include ($_SERVER['DOCUMENT_ROOT'].'/IMS/config.php');




$database   = new DatabaseConnection();
$dbCon      = $database->getConnection();

//User Login
$general    = new General();
//Database CRUD Operations
$dbCRUD     = new databaseCRUD($dbCon);
//Database Classes
$category   = new category($dbCon);
$employee   = new employee();
$users 		= new Users($dbCon);

$errors = array();

$companyName ="Panditharatne Constructions";



?>