<?php
require_once("head.php");
$host="50.62.209.6:3306"; // Host name
$user="please"; // Mysql username
$pass="Rixq00&7"; // Mysql password

$con = mysqli_connect("$host", "$user", "$pass", "stacksity_")or die("0");
mysqli_set_charset($con, "utf8mb4");
mysqli_query($con,"SET NAMES utf8mb4");
