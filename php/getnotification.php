<?php
require_once("head.php");
if(isset($_GET['session_id'])){
    session_id($_GET['session_id']);
}
session_start();
if(isset($_SESSION['user_id'])&&isset($_GET['timestamp'])){
    include_once 'connect.php';
    $u_id = mysqli_real_escape_string($con, $_SESSION['user_id']);
    $timestamp = mysqli_real_escape_string($con, $_GET['timestamp']);
    if($timestamp!=0){
        $sql = "SELECT n.*, u.username, u.stack_id FROM notifications n
                  INNER JOIN users u ON u.user_id = n.from_user
                WHERE to_user = $u_id AND note_time > '$timestamp'
                ORDER BY note_time DESC LIMIT 7";
    }else{
        $sql = "SELECT n.*, u.username, u.stack_id FROM notifications n
                  INNER JOIN users u ON u.user_id = n.from_user
                WHERE to_user = $u_id ORDER BY note_time DESC LIMIT 10";
    }
    $result = mysqli_query($con, $sql);
    if($result === false){
        echo '{error: problem}';
        throw new Exception(mysqli_error($sql));
    }
    while($row = mysqli_fetch_assoc($result)){
        $data[] = $row;
    }
    if(!isset($data)){
        echo 'null';
    }else{
        $data = array_reverse($data);
        include_once 'humantime.php';
        for($x = 0; $x < sizeof($data); $x++){
            $data[$x]['created'] = humanTiming(($data[$x]['note_time'])).' ago';
        }
        echo json_encode($data);
    }
}else{
    echo '{error: problem}';
}
