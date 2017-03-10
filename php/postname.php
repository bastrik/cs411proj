<?php
require_once("head.php");
if(isset($_GET['id'])&&is_numeric($_GET['id'])){
    if(isset($_GET['session_id'])){
        session_id($_GET['session_id']);
    }
    session_start();
    $login = isset($_SESSION['user_id']);
    include_once "connect.php";
    $sql;
    $p_id = $_GET['id'];
    if($login){
        $u_id = $_SESSION['user_id'];
        $u_stack = $_SESSION['stack_id'];
        $sql = "SELECT x.*,
           y.username,y.flair,
           s.stackname, s.stackflair
            FROM posts x
              INNER JOIN users y ON x.user_id = y.user_id
              INNER JOIN stacks s ON s.stack_id = x.stack_id
            WHERE x.post_id = $p_id AND visible = 1 AND (x.private = 0 OR (x.private = 1 AND ( x.user_id = '$u_id' OR x.stack_id = '$u_stack')))";
    }else{
        $sql = "SELECT x.*,
           y.username,y.flair,
           s.stackname, s.stackflair
            FROM posts x
              INNER JOIN users y ON x.user_id = y.user_id
              INNER JOIN stacks s ON s.stack_id = x.stack_id
            WHERE x.post_id = $p_id AND visible = 1 AND x.private = 0";
    }

    $result = mysqli_query($con, $sql);
    if($result === false){
        echo '{error: problem}';
        throw new Exception(mysqli_error($sql));
    }

    while($row = mysqli_fetch_assoc($result)){
        $data = $row;
    }include_once 'humantime.php';
    if(isset($data)){
        if(isset($_SESSION['user_id'])){
            $sql = "SELECT *
    FROM votes
    WHERE user_id = '".$_SESSION['user_id']."' AND
    post_id = '".$data['post_id']."'";
            $res = mysqli_query($con, $sql) or die('error');
            if(mysqli_num_rows($res)==0){
                $data['vote'] = 1;
            }else{
                while($row = mysqli_fetch_assoc($res)){
                    $data['vote'] = $row['vote_type'];
                }
            }
        }else{
            $data['vote'] = 1;
        }
        $data['created'] = humanTiming(strtotime($data['created'])).' ago';
        if($login){
            if($data['user_id']==$_SESSION['user_id']){
                $data['delete'] = true;
            }
            $data['report'] = 1;
        }else{
            $data['report'] = 0;
            $data['delete'] = false;
        }
    }
    echo json_encode($data);
}
