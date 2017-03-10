<?php
require_once("head.php");
if(isset($_POST['session_id'])){
    session_id($_POST['session_id']);
}
session_start();
if(isset($_SESSION['user_id'])&&isset($_POST['nsfw'])){
    $setting = !strcmp($_POST['nsfw'],'true');
    if($setting){
        $setting = 1;
    }else{
        $setting = 0;
    }
    include_once "../php/connect.php";
    mysqli_query($con, "UPDATE users SET nsfw = $setting WHERE user_id = '".$_SESSION["user_id"]."'");
    echo $setting;
    $_SESSION['nsfw'] = $setting;
}
