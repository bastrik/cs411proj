<?php
require_once("head.php");
include_once "connect.php";
$sql;
session_start();
$postid = $_GET['id'];
if(isset($_GET['session_id'])){
    session_id($_GET['session_id']);
}

$login = isset($_SESSION['user_id']);

    $sql = "SELECT x.*,
           y.username,y.flair,
           s.stackname, s.stackflair
FROM posts x
  INNER JOIN users y ON x.user_id = y.user_id
  INNER JOIN stacks s ON s.stack_id = x.stack_id
WHERE x.post_id = $postid AND visible = 1 AND x.private = 0";

$result = mysqli_query($con, $sql);
if($result === false){
    echo '{error: problem}';
    throw new Exception(mysqli_error($sql));
}
$count = false;
while($row = mysqli_fetch_assoc($result)){
    $data = $row;
    $count = true;
}
if(!$count){
    header('location:../php/postnotfound.php');
    exit();
}
$login = false;
include_once 'humantime.php';
if(isset($data)){
    if($login){
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
        $data['report'] = 1;
    }else{
        $data['report'] = 0;
        $data['vote'] = 1;
    }
    $data['created'] = humanTiming(strtotime($data['created'])).' ago';
    if($login){
        if($data['user_id']==$_SESSION['user_id']){
            $data['delete'] = true;
        }
    }else{
        $data['delete'] = false;
    }
    $postname = $data["title"];
    $image = "https://stacksity.com/img/post/thumb.jpg";
    if(isset($data['posttype'])&&$data['posttype']=="2"){
        $image = $data['link'];
    }else if(isset($data['image'])){
        $image = $data['image'];
    }
}
$postdata = json_encode($data);
