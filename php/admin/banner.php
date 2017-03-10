<?php
if(isset($_POST['stackid'])&&isset($_POST['banner'])&&is_numeric($_POST['stackid'])){
    session_start();
    if(isset($_SESSION['admin'])&&$_SESSION['admin']==1){
        include_once "../connect.php";
        $banner = mysqli_real_escape_string($con, $_POST['banner']);
        $id = mysqli_real_escape_string($con, $_POST['stackid']);
        if($banner==""||!isset($banner)){
            mysqli_query($con, "UPDATE stacks SET banner = NULL WHERE stack_id = $id");
        }else{
            mysqli_query($con, "UPDATE stacks SET banner = '$banner' WHERE stack_id = $id");
        }
        echo "https://stacksity.com/stack.php?id=".$id;
    }else{
        echo "1";
    }
}else{
    echo "1";
}