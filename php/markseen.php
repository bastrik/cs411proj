<?php
require_once("head.php");
if(isset($_POST['session_id'])){
    session_id($_POST['session_id']);
}
session_start();
if(isset($_SESSION['user_id'])){
    $data = json_decode(stripslashes($_POST['seen']));
    echo $data;
    include_once "connect.php";
    mysqli_query($con, 'UPDATE notifications SET seen = TRUE WHERE to_user = "'.$_SESSION['user_id'].'"');
}
