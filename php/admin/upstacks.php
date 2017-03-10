<?php
/**
 * Created by PhpStorm.
 * User: Tyler
 * Date: 11/28/2015
 * Time: 6:26 PM
 */
session_start();
if(isset($_SESSION['admin'])&&$_SESSION['admin']==1){
    include_once "../connect.php";

    $sql = mysqli_query($con, "SELECT x.vote_type, x.post_id, y.title, z.username FROM votes x INNER JOIN posts y ON x.post_id = y.post_id INNER JOIN users z ON x.user_id = z.user_id ORDER BY x.vote_id DESC LIMIT 500");

    while($row = mysqli_fetch_assoc($sql)){
        $vote = " upstacked ";
        if($row["vote_type"] == 1){
            $vote = " devoted ";
        }elseif($row["vote_type"] == 0){
            $vote = " downstacked ";
        }
        echo("<b>".$row["username"]."</b>".$vote.$row["title"]." | ".$row["post_id"]."<br>");
    }
}
