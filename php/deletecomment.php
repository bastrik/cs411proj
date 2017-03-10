<?php
require_once("head.php");
if(isset($_POST['session_id'])){
    session_id($_POST['session_id']);
}
session_start();
if(isset($_SESSION['user_id'])&&isset($_POST['delid'])&&$_POST['delid']!=0){
    include_once 'connect.php';
    $commentid = mysqli_real_escape_string($con, $_POST['delid']);
    $u_id = mysqli_real_escape_string($con, $_SESSION['user_id']);
    $sql = mysqli_query($con, "UPDATE comments SET visible = 0 WHERE comment_id = $commentid AND user_id = $u_id");
    if($sql){
        echo '0';
    }else{
        echo 'Can not delete, query failed. Login or try again';
    }
}else{
    echo 'Not logged in or invalid post parameters';
}
