<?php
require_once("head.php");
$host="webhost.engr.illinois.edu"; // Host name
$user="rzhang56_admin"; // Mysql username
$pass="Playing4fun"; // Mysql password

$con = mysqli_connect("$host", "$user", "$pass", "rzhang56_demoBackend")or die("0");
if (!$con) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}
mysqli_set_charset($con, "utf8mb4");
mysqli_query($con,"SET NAMES utf8mb4");
echo 'success';
