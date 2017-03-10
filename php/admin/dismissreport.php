<?php
if(isset($_GET['id'])&&is_numeric($_GET['id'])){
    session_start();
    if(isset($_SESSION['admin'])&&$_SESSION['admin']==1){
        include_once "../connect.php";
        $id = mysqli_real_escape_string($con, $_GET["id"]);
        mysqli_query($con, "UPDATE reportlog SET resolved = 1 WHERE reportlog_id = $id");
    }else{
        echo "1";
    }
}else{
    echo "1";
}