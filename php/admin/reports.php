<?php
session_start();
if(isset($_SESSION['admin'])&&$_SESSION['admin']==1){
    include_once "../connect.php";
    $result = mysqli_query($con, "SELECT * FROM reportlog WHERE resolved = 0");
    while($row = mysqli_fetch_assoc($result)){
        $data[] = $row;
    }
    echo json_encode($data);
}else{
    echo "1";
}