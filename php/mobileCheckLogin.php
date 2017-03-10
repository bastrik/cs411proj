<?php
/*checks if the user is logged in*/
require_once("head.php");
if(isset($_POST['session_id'])){
    session_id($_POST['session_id']);
}
session_start();
if(isset($_SESSION['user_id'])&&isset($_SESSION['username'])&&isset($_SESSION['stack_id'])){
    echo '1';
}else{
    if(isset($_POST['hashcode'])){
        include_once "connect.php";
        $hash = mysqli_real_escape_string($con, $_POST['hashcode']);

        $query = mysqli_query($con, "SELECT user_id FROM login WHERE hash = '".$hash."' LIMIT 1");
        if(mysqli_num_rows($query)>0){
            while($row = mysqli_fetch_assoc($query)){
                $uid = $row['user_id'];
            }
            $sql = mysqli_query($con, "SELECT * FROM users WHERE user_id = '".$uid."'");
            while($row = mysqli_fetch_assoc($sql)){
                $_SESSION['stack_id']=$row['stack_id'];
                $_SESSION['user_id']=$row['user_id'];
                $_SESSION['username']=$row['username'];
                $_SESSION['admin']=$row['admin'];
                $_SESSION['nsfw']=$row['nsfw'];
            }
            echo session_id();
        }else{
            echo '0';
        }
    }else {
        echo '0';
    }
}
