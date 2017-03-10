<?php
require_once("head.php");
function validstack($stack){
    if(preg_match('/^\$[A-Za-z0-9_]+$/', $stack) == 1 && strlen($stack)<60 && !is_numeric(substr($stack, 1))){
        return true;
    }
    return false;
}

$follow = false;
$nsfw = 0;
if($stack == '0' || $stack == '$best'){
    $stack_desc = "Your frontpage of stacks";
    $stackname = "\$best";
    $is_user = true;
    $stack = '0';
}else if($stack == '-1' || $stack == '$everything'){
    $stack_desc = "The latest from every stack of Stacksity";
    $stackname = "\$everything";
    $is_user = true;
    $stack = -1;
}else if($stack == '-2' || $stack == '$followed'){
    $stack_desc = "Posts from all the user stacks that you are following";
    $stackname = "\$followed";
    $is_user = true;
    $stack = -2;
}else if($stack == '-3' || $stack == '$recent'){
    $stack_desc = "The newest posts from around Stacksity";
    $stackname = "\$recent";
    $stack = -3;
    $is_user = true;
}else if($stack == '-4' || $stack == '$near' || $stack == '4917'){
    $stack_desc = "Nearby posts sorted by distance";
    $stackname = "\$near";
    $stack = 4917;
    $is_user = false;
}else{
    include_once "connect.php";
    $untouch = $stack;
    $stack = mysqli_real_escape_string($con, $stack);

    if(is_numeric($stack)){
        $state = "SELECT stack_id, stackname, stack_desc, is_user, nsfw, followers, theme, banner FROM stacks WHERE stack_id = '$stack' LIMIT 1";
    }else{
        $state = "SELECT stack_id, stackname, stack_desc, is_user, nsfw, followers, theme, banner FROM stacks WHERE LOWER(stackname) = '".$stack."' LIMIT 1";
    }
    $sql = mysqli_query($con, $state) or die("0");

    if(mysqli_num_rows($sql)==0){
        if(validstack($untouch)){
            //$stackcreate = $_GET['stack'];
            //if(isset($stackcreate)&&validstack($stackcreate)){
            mysqli_query($con, "INSERT INTO stacks (stackname, is_user) VALUES ('".$stack."' , 0)");
            $stackname = $stack;
            $stack = mysqli_insert_id($con);
            $stack_desc = "";
            $is_user = false;
            $followers = 0;
            $nsfw = false;
            //}else{
            //    header('location: /php/stacknotfound.php?name='.$stack);
            //}
        }else{
            header('location:/php/stacknotfound.php');
        }
    }else{
        while($data = mysqli_fetch_assoc($sql)){
            $stack = $data['stack_id'];
            $stackname = $data['stackname'];
            $stack_desc = $data['stack_desc'];
            $is_user = $data['is_user'];
            $followers = $data['followers'];
            $theme = $data['theme'];
            $banner = $data['banner'];
            $nsfw = ($data['nsfw']!=0);
        }
        if($login){
            $row = mysqli_query($con, "SELECT following FROM follow WHERE stack_id = $stack AND user_id = '".$_SESSION['user_id']."'");
            while($values = mysqli_fetch_assoc($row)){
                if($values['following']==1){
                    $follow = true;
                }
            }
        }
    }
}
