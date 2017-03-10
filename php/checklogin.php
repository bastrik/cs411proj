<?php
require_once("head.php");
if(!isset($_SESSION['user_id'])&&isset($_COOKIE['user_id'])){
    if(isset($_COOKIE['hashcheck'])&&isset($_COOKIE['username'])){
        include_once "connect.php";
        //$ip = $_SERVER['REMOTE_ADDR'];
        //$ip = ip2long($ip);
        //$hash = md5(sha1("!*K".$ip.$_COOKIE['username'].$_COOKIE['user_id']."%)d"));
        $hash = mysqli_real_escape_string($con, $_COOKIE['hashcheck']);
        $query = mysqli_query($con, "SELECT 1 FROM login WHERE user_id = '".$_COOKIE['user_id']."' AND hash = '".$hash."'");
        if(mysqli_num_rows($query)>0){
            $sql = mysqli_query($con, "SELECT * FROM users WHERE user_id = '".$_COOKIE['user_id']."'");
            while($row = mysqli_fetch_assoc($sql)){
                $_SESSION['stack_id']=$row['stack_id'];
                $_SESSION['user_id']=$row['user_id'];
                $_SESSION['username']=$row['username'];
                $_SESSION['admin']=$row['admin'];
                $_SESSION['nsfw']=$row['nsfw'];
            }
        }
    }
}
