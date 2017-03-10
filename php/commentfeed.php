<?php
require_once("head.php");
if(isset($_GET['post_id'])&&is_numeric($_GET['post_id'])){

    if(isset($_GET['session_id'])){
        session_id($_GET['session_id']);
    }

    session_start();
    $login = isset($_SESSION['user_id']);
    include_once 'connect.php';

    $post_id = mysqli_real_escape_string($con, $_GET['post_id']);
    if(isset($_GET['comment_id'])){
        $comment_id = mysqli_real_escape_string($con, $_GET['comment_id']);
    }
    echo json_encode(getComment(0,0));
}

function convert_accent($string)
{
    return htmlentities($string, ENT_COMPAT, 'UTF-8');
}
function getComment($id,$depth){
    $item = null;
    $data = (comment($id));
    if($data != null){
        foreach ($data as $val) {
            //echo $val['comment_id'];
            $val["depth"]=$depth;
            if($depth<7){
                $next = getComment($val['comment_id'],$depth+1);
                if($next!=null) $val['comments'] = $next;
            }
            $item[] = $val;
        }
    }
    return $item;
}
function comment($comment_id){
        global $con;
        global $login;
        global $post_id;
        $formula = "upstacks - downstacks";
        if($comment_id == 0){
            $sql = "SELECT x.*, y.username, y.flair
        FROM comments x
          INNER JOIN users y ON y.user_id = x.user_id
      WHERE x.post_id = $post_id AND depth = 0
      ORDER BY $formula DESC";
        }else{
            $sql = "SELECT x.*, y.username, y.flair
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
        $data = null;
        while($row = mysqli_fetch_assoc($result)){
            $data[] = $row;
        }
        include_once 'humantime.php';
        for($x = 0; $x < sizeof($data); $x++){
            $data[$x]['vote'] = 1;
            if($login){
                $sql = "SELECT *
            FROM commentvote
            WHERE user_id = '".$_SESSION['user_id']."' AND
            comment_id = '".$data[$x]['comment_id']."'";
                $res = mysqli_query($con, $sql) or die('error');
                if(mysqli_num_rows($res)!=0){
                    while($row = mysqli_fetch_assoc($res)){
                        $data[$x]['vote'] = $row['vote_type'];
                    }
                }
            }
            $data[$x]['created'] = humanTiming(strtotime($data[$x]['created']));
            if($data[$x]['edit']!=null){
                $data[$x]['edit'] = humanTiming(strtotime($data[$x]['edit']));
            }
            $data[$x]['delete'] = false;
            if($login){
                if($data[$x]['user_id']==$_SESSION['user_id']){
                    $data[$x]['delete'] = true;
                }
            }
            if($data[$x]['visible']==false){
                $data[$x]['content'] = '[deleted]';
                $data[$x]['delete'] = false;
            }
            if($data[$x]['raw']==null){
                $data[$x]['raw'] = $data[$x]['content'];
            }
//            }else{
//                $data[$x]['content']==convert_accent($data[$x]['content']);
//            }
        }
        return $data;
    }
