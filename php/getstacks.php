<?php
require_once("head.php");
//$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
//strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
//if(!$isAjax) {
//    $user_error = 'Access denied - not an AJAX request...';
//    trigger_error($user_error, E_USER_ERROR);
//}
if(isset($_GET['session_id'])){
    session_id($_GET['session_id']);
}
$sql;
session_start();
if(isset($_GET['id'])&&isset($_SESSION['user_id'])){
    include_once "connect.php";
    $u_id = $_SESSION['user_id'];
    if($_GET['id']==1){
        $stack_id = $_SESSION['stack_id'];
        $sql = "SELECT x.*, s.stackname
        FROM follow x
          INNER JOIN stacks s ON s.stack_id = x.stack_id
        WHERE x.user_id = '$u_id' AND NOT (x.stack_id = $stack_id) AND s.is_user=1 AND following = TRUE
        ORDER BY s.stackname ASC";
    }else if($_GET['id']==2){
        $sql = "SELECT x.*, s.stackname
        FROM follow x
          INNER JOIN stacks s ON s.stack_id = x.stack_id
        WHERE x.user_id = '$u_id' AND s.is_user=0 AND following = TRUE
        ORDER BY s.stackname ASC";
    }
    $result = mysqli_query($con, $sql);
    if($result === false){
        echo '{error: problem}';
        throw new Exception(mysqli_error($sql));
    }

    while($row = mysqli_fetch_assoc($result)){
        $data[] = $row;
    }
    echo json_encode($data);
}
