<?php
require_once("head.php");
if(isset($_POST['session_id'])){
    session_id($_POST['session_id']);
}
session_start();
if(isset($_SESSION['user_id'])&&isset($_POST["name"])){
    include_once "connect.php";

    $_POST["name"] =  convert_accent($_POST["name"]);

    $bio = mysqli_real_escape_string($con, $_POST["name"]);

	$sql = "UPDATE stacks SET stack_desc = '$bio' WHERE stack_id = '".$_SESSION['stack_id']."'";
	if(mysqli_query($con, $sql )){
		echo "0";
	} else {
    echo "Error updating record: " . mysqli_error($con);
	}
	mysqli_close($con);
}
function convert_accent($string)
{
    return htmlspecialchars($string);
}
