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

    $sql = mysqli_query($con, "SELECT content, username, created FROM comments x INNER JOIN users y ON x.user_id = y.user_id ORDER BY x.created DESC LIMIT 100");

    while($row = mysqli_fetch_assoc($sql)){
        echo($row["content"]."<b>".$row["username"]." | ".$row['created']."</b><br><br>");
    }
}
