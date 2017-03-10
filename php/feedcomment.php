<?php
require_once("head.php");
//$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
//strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
//if(!$isAjax) {
//    $user_error = 'Access denied - not an AJAX request...';
//    trigger_error($user_error, E_USER_ERROR);
//}

if(isset($_GET['post_id'])&&is_numeric($_GET['post_id'])&&is_numeric($_GET['comment_id'])){

    if(isset($_GET['session_id'])){
        session_id($_GET['session_id']);
    }

    session_start();
    $login = isset($_SESSION['user_id']);
    include_once 'connect.php';
    $post_id = mysqli_real_escape_string($con, $_GET['post_id']);
    $comment_id = mysqli_real_escape_string($con, $_GET['comment_id']);
    $sql;
    $formula = "upstacks - downstacks";
    if($comment_id == 0){
        $sql = "SELECT x.*, y.username
        FROM comments x
          INNER JOIN users y ON y.user_id = x.user_id
      WHERE x.post_id = $post_id AND depth = 0
      ORDER BY $formula DESC";
    }else{
        $sql = "SELECT x.*, y.username
        FROM comments x
          INNER JOIN users y ON y.user_id = x.user_id
      WHERE x.post_id = $post_id AND link_id = $comment_id
      ORDER BY $formula DESC";
    }
    $result = mysqli_query($con, $sql);
    if($result === false){
        echo '{error: problem}';
        throw new Exception(mysqli_error($sql));
    }
    while($row = mysqli_fetch_assoc($result)){
        $data[] = $row;
    }
    include_once 'humantime.php';
    for($x = 0; $x < sizeof($data); $x++){
        $sql = "SELECT *
        FROM commentvote
        WHERE user_id = '".$_SESSION['user_id']."' AND
        comment_id = '".$data[$x]['comment_id']."'";
        $res = mysqli_query($con, $sql) or die('error');
        if(mysqli_num_rows($res)==0){
            $data[$x]['vote'] = 1;
        }else{
            while($row = mysqli_fetch_assoc($res)){
                $data[$x]['vote'] = $row['vote_type'];
            }
        }
        $data[$x]['created'] = humanTiming(strtotime($data[$x]['created'])).' ago';
        $data[$x]['delete'] = false;
        if($login){
            if($data[$x]['user_id']==$_SESSION['user_id']||$_SESSION['admin']){
                $data[$x]['delete'] = true;
            }
        }
        if($data[$x]['visible']==false){
            $data[$x]['content'] = '[deleted]';
            $data[$x]['delete'] = false;
        }else{
            $data[$x]['content']==convert_accent($data[$x]['content']);
        }
    }
    echo json_encode($data);
}
function convert_accent($string)
{
    return htmlentities($string, ENT_COMPAT, 'UTF-8');
}
