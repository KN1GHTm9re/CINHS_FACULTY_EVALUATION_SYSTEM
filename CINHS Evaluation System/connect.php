<?php

$servername = "localhost";
$username = "";
$password = "";
$database = "cinhs";

$connect = mysqli_connect($servername, $username, $password, $database);

// Check connection
if ($connect->connect_error) {
  die("Connection failed: " . $connect->connect_error);
}

?>