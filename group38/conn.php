<?php
$host = "localhost";
$user = "root";
$pass = "root";
$db = "group38";
$conn = mysqli_connect($host, $user, $pass, $db);
if (!$conn) 
{
  die("Connection failed: " . mysqli_connect_error());
}
?>