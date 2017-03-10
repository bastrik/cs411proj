<?php
require_once("head.php");
if(isset($_POST['session_id'])){
    session_id($_POST['session_id']);
}
session_start();
if($_POST['id']&&isset($_SESSION['user_id']))
{
    include_once("connect.php");
    $uid = mysqli_real_escape_string($con, $_SESSION['user_id']);
    $pid = mysqli_real_escape_string($con,$_POST['id']);
    $row = mysqli_query($con, "SELECT * FROM votes WHERE user_id = '$uid' AND post_id = '$pid' ");
    $rows = mysqli_num_rows($row);
    if($rows == 0){
        echo "none";
        mysqli_query($con, "INSERT INTO votes (user_id, post_id, vote_type) VALUES ( '$uid' , '$pid' , 2)");
        mysqli_query($con, "UPDATE posts SET upstacks = upstacks+1 WHERE post_id = '$pid' ");
    }else{
        while($data = mysqli_fetch_assoc($row)){
            $type = $data['vote_type'];
            if($type == 2){
                mysqli_query($con, "UPDATE votes SET vote_type = 1 WHERE post_id = '$pid' AND user_id = '$uid' ");
                mysqli_query($con, "UPDATE posts SET upstacks = upstacks-1 WHERE post_id = '$pid' ");
//                echo $type." ".$uid." ".$pid;
            }else if($type == 0){
                mysqli_query($con, "UPDATE votes SET vote_type = 2 WHERE post_id = '$pid' AND user_id = '$uid' ");
                mysqli_query($con, "UPDATE posts SET upstacks = upstacks+1, downstacks = downstacks-1 WHERE post_id = '$pid' ");
            }else if($type == 1){
                mysqli_query($con, "UPDATE votes SET vote_type = 2 WHERE post_id = '$pid' AND user_id = '$uid' ");
                mysqli_query($con, "UPDATE posts SET upstacks = upstacks+1 WHERE post_id = '$pid' ");
            }
        }
    }
}
?>
