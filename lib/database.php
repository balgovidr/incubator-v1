<?php
	$servername = "localhost";
	$username = "root";
	$password = "";
	$db="ideas_sdeia";
	$conn = mysqli_connect($servername, $username, $password,$db);

    if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  exit();
};
DEFINE('BASE_URL','http://localhost');
?>