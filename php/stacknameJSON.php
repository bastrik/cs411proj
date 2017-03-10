<?php
require_once("head.php");
function validstack($stack){
    if(preg_match('/^\$[A-Za-z0-9_]+$/', $stack) == 1 && strlen($stack)<60 && !is_numeric(substr($stack, 1))){
        return true;
    }
    return false;
}
if(isset($_POST['stack'])){
    $d['following']= false;
    $d['stack']= $_POST['stack'];
    if($d['stack'] == '0' || $d['stack'] == '$best'){
        $d['stack_desc'] = "Your frontpage of stacks";
        $d['stackname'] = "\$best";
        $d['is_user'] = true;
        $d['stack'] = 0;
    }else if($d['stack'] == '-1' || $d['stack'] == '$everything'){
        $d['stack_desc'] = "The latest from every stack of Stacksity";
        $d['stackname'] = "\$everything";
        $d['is_user'] = true;
        $d['stack'] = -1;
    }else if($d['stack'] == '-2' || $d['stack'] == '$followed'){
        $d['stack_desc'] = "Posts from all the user stacks that you are following";
        $d['stackname'] = "\$followed";
        $d['stack'] = -2;
        $is_user = true;
    }else if($d['stack'] == '-3' || $d['stack'] == '$recent'){
        $d['stack_desc'] = "The newest posts from around Stacksity";
        $d['stackname'] = "\$recent";
        $is_user = true;
        $d['stack'] = -3;
    }else if($d['stack'] == '-4' || $d['stack'] == '$near' || $stack == '4917'){
        $d['stack_desc'] = "Nearby posts sorted by distance";
        $d['stackname'] = "\$near";
        $is_user = false;
        $d['stack'] = 4917;
    }else{
        include_once "connect.php";

        $stack = mysqli_real_escape_string($con, $d['stack']);

        if(is_numeric($d['stack'])){
            $state = "SELECT stack_id, stackname, stack_desc, is_user, nsfw, followers, theme, banner FROM stacks WHERE stack_id = '$stack' LIMIT 1";
        }else{
            $state = "SELECT stack_id, stackname, stack_desc, is_user, nsfw, followers, theme, banner FROM stacks WHERE stackname = '".$stack."' LIMIT 1";
        }
        $sql = mysqli_query($con, $state) or die("0");

        if(mysqli_num_rows($sql)==0){
            if(validstack($d['stack'])){
                mysqli_query($con, "INSERT INTO stacks (stackname, is_user) VALUES ('".$d['stack']."' , 0)");
                $d['stackname'] = $d['stack'];
                $d['stack'] = mysqli_insert_id($con);
                $d['stack_desc'] = "";
                $d['is_user'] = 0;
                $d['followers'] = 0;
                $d['nsfw'] = false;
                $d['banner'] = null;
            }else{
                die("1");
            }
        }else{
            while($data = mysqli_fetch_assoc($sql)){
                $d['stack'] = $data['stack_id'];
                $d['stackname'] = $data['stackname'];
                $d['stack_desc'] = $data['stack_desc'];
                $d['is_user'] = $data['is_user'];
                $d['followers'] = $data['followers'];
                $d['banner'] = $data['banner'];
                $d['nsfw'] = ($data['nsfw']!=0);
            }
            if(isset($_POST['session_id'])){
                session_id($_POST['session_id']);
            }
            session_start();
            if(isset($_SESSION['user_id'])){
                if($_SESSION['stack_id']==$d['stack']){
                    $d['following']= true;
                }else{
                    $uid = mysqli_real_escape_string($con, $_SESSION['user_id']);
                    $row = mysqli_query($con, "SELECT following FROM follow WHERE stack_id = '".$d['stack']."' AND user_id = '".$uid."'");
                    while($values = mysqli_fetch_assoc($row)){
                        if($values['following']==1){
                            $d['following'] = true;
                        }
                    }
                }
            }
        }
    }
    echo json_encode($d);
}
