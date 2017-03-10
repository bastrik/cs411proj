<?php
require_once("head.php");
session_start();
if(isset($_SESSION['admin'])&&$_SESSION['admin']==1){
    include_once 'connect.php';
    $sql = "SELECT x.*
    FROM posts x
      INNER JOIN stacks s ON s.stack_id = x.stack_id
    WHERE s.is_user = 0 AND visible = 1
    ORDER BY
        UNIX_TIMESTAMP( created ) DESC
    LIMIT 10";

    $result = mysqli_query($con, $sql);
    if($result === false){
        echo '{error: problem}';
        throw new Exception(mysqli_error($sql));
    }
    $num = 0;
    while($row = mysqli_fetch_assoc($result)){
        //$vote = rand(0,10);
        $num++;
        $up = $row['upstacks'];
        if($up<5){
            $vote = rand(10,30-$num);
            echo '"'.$row['title'].'" received '.$vote." fake votes. It now has ".($up+$vote)." upstacks<br>";
            $id = $row['post_id'];
            $sql = "UPDATE posts SET upstacks = upstacks + $vote WHERE post_id = $id";
            mysqli_query($con, $sql);
        }
    }
    echo "okay there u go more fake votes yay";
}
