<?php
ini_set('display_errors',0);
error_reporting(E_ALL);
$servername = "localhost";
$username = "root";
$password = "";
$database = "mlm_ecommerce";

// Create connection
$con = mysqli_connect($servername, $username, $password, $database);

// Check connection
if(mysqli_connect_errno()){
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  exit();
}

mysqli_query($con,"SET CHARACTER SET utf8");
mysqli_query($con,"SET SESSION collation_connection ='utf8_general_ci'");

date_default_timezone_set("Asia/Kolkata");

$date = date("Y-m-d");
$time = date("H:i:s");
$day = date("l");
$month = date("F");
$year = date("Y");
$timestamp = date("Y-m-d H:i:s");

$allowedImgExt = array('jpg', 'JPG', 'jpeg', 'JPEG', 'png', 'PNG', 'gif', 'webp', 'tiff', 'tif');
?>