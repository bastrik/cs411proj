<?php
require_once("head.php");
if(isset($_POST['session_id'])){
    session_id($_POST['session_id']);
}
session_start();
if(isset($_SESSION['user_id'])&&isset($_POST['relid'])&&$_POST['relid']!=0&&is_numeric($_POST['relid'])&&strlen($_POST['relid'])<11){
    include_once 'connect.php';
    //this creates/checks a new entry in the reports table, which identifies individual reports
    $postid = mysqli_real_escape_string($con, $_POST['relid']);
    $u_id = mysqli_real_escape_string($con, $_SESSION['user_id']);
    $sql = mysqli_query($con, "SELECT 1 FROM reports WHERE post_id = $postid AND user_id = $u_id LIMIT 1");
    if(mysqli_num_rows($sql)==0){
        $sql = mysqli_query($con, "INSERT INTO reports (post_id, user_id) VALUES ($postid, $u_id)");

        //this creates/checks the reportlog table, which contains the posts that have been reported and how many reports there are.
        $sql = mysqli_query($con, "SELECT 1 FROM reportlog WHERE post_id = $postid");
        if(mysqli_num_rows($sql)==0){
            $sql = mysqli_query($con, "INSERT INTO reportlog (post_id) VALUES ($postid)");
        }else{
            $sql = mysqli_query($con, "UPDATE reportlog SET reports = reports+1 WHERE post_id = $postid");
        }
    }else{
        echo "you have already reported this post";
    }
}else{
    echo 'Not logged in or invalid post parameters';
}
