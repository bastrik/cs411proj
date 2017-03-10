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

    $sql = mysqli_query($con, "SELECT username, made_date FROM users ORDER BY user_id DESC LIMIT 100");

    while($row = mysqli_fetch_assoc($sql)){
        echo($row["username"]." | ".$row['made_date']."</b><br>");
    }
}