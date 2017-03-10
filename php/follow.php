<?php
require_once("head.php");
if(isset($_POST['session_id'])){
    session_id($_POST['session_id']);
}
session_start();
if(isset($_POST['stack'])&&isset($_SESSION['user_id'])){
    include_once 'connect.php';
    $u_id = $_SESSION['user_id'];
    $stackid = $_POST['stack'];
    $stackid = mysqli_real_escape_string($con, $stackid);
    $sql = mysqli_query($con,'SELECT following FROM follow WHERE user_id = "'.$u_id.'" AND stack_id = "'.$stackid.'"');
    if(mysqli_num_rows($sql)==0){
        mysqli_query($con,'INSERT INTO follow (user_id, stack_id, following) VALUES ( "'.$u_id.'", "'.$stackid.'", TRUE )');
        mysqli_query($con,'UPDATE stacks SET followers = followers + 1 WHERE stack_id = "'.$stackid.'"');
    }else{
        while($row = mysqli_fetch_assoc($sql)){
            if($row["following"]){
                mysqli_query($con,'UPDATE stacks SET followers = followers - 1 WHERE stack_id = "'.$stackid.'"');
            }else{
                mysqli_query($con,'UPDATE stacks SET followers = followers + 1 WHERE stack_id = "'.$stackid.'"');
            }
            mysqli_query($con,'UPDATE follow SET following = NOT following WHERE stack_id = "'.$stackid.'" AND user_id = "'.$u_id.'"');
        }
    }
}
