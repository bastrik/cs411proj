<?php
require_once("head.php");
if(isset($_POST['session_id'])){
    session_id($_POST['session_id']);
}
session_start();
if($_POST['id']&&isset($_SESSION['user_id']))
{
    include_once("connect.php");
    $uid = $_SESSION['user_id'];
    $pid = mysqli_real_escape_string($con,$_POST['id']);
    $row = mysqli_query($con, "SELECT * FROM commentvote WHERE user_id = '$uid' AND comment_id = '$pid' ");
    $rows = mysqli_num_rows($row);
    if($rows == 0){
        echo "none";
        mysqli_query($con, "INSERT INTO commentvote (user_id, comment_id, vote_type) VALUES ( '$uid' , '$pid' , 2)");
        mysqli_query($con, "UPDATE comments SET upstacks = upstacks+1 WHERE comment_id = '$pid' ");
    }else{
        while($data = mysqli_fetch_assoc($row)){
            echo "vote type";
            $type = $data['vote_type'];
            if($type == 2){
                mysqli_query($con, "UPDATE commentvote SET vote_type = 1 WHERE comment_id = '$pid' AND user_id = '$uid' ");
                mysqli_query($con, "UPDATE comments SET upstacks = upstacks-1 WHERE comment_id = '$pid' ");
            }else if($type == 0){
                mysqli_query($con, "UPDATE commentvote SET vote_type = 2 WHERE comment_id = '$pid' AND user_id = '$uid' ");
                mysqli_query($con, "UPDATE comments SET upstacks = upstacks+1, downstacks = downstacks-1 WHERE comment_id = '$pid' ");
            }else if($type == 1){
                mysqli_query($con, "UPDATE commentvote SET vote_type = 2 WHERE comment_id = '$pid' AND user_id = '$uid' ");
                mysqli_query($con, "UPDATE comments SET upstacks = upstacks+1 WHERE comment_id = '$pid' ");
            }
        }
    }
}
?>
