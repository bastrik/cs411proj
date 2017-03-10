<?php
/**
 * Created by PhpStorm.
 * User: Tyler
 * Date: 11/28/2015
 * Time: 6:26 PM
 */
session_start();
if(isset($_SESSION['admin'])&&$_SESSION['admin']==1){

    $number = $_POST["vote"];
    $post_id = $_POST["postid"];

    include_once "../connect.php";

    $number = mysqli_real_escape_string($con, $number);
    if($post_id < 0){
        $post_id = abs($post_id);
        $post_id = mysqli_real_escape_string($con, $post_id);
        $sql = mysqli_query($con, "UPDATE posts SET downstacks = $number WHERE post_id = $post_id");
    }else{
        $post_id = mysqli_real_escape_string($con, $post_id);
        $sql = mysqli_query($con, "UPDATE posts SET upstacks = $number WHERE post_id = $post_id");
    }
}