<?php
header("Content-Type: text/html; charset=UTF-8");

$dbhost = '127.0.0.1:49527';
$dbuser = 'azure';
$dbname = 'quizz';
$dbpass = '6#vWHD_$';

$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

if (!$conn) {
  echo "Error: Unable to connect to MySQL." . PHP_EOL;
  echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
  echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
  exit;
}

mysqli_query($conn,"SET NAMES 'utf8'");
mysqli_query($conn,'SET CHARACTER SET utf8');
?>
