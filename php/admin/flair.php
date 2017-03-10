<?php

//sets the flair by modifying both the stack table and the users table, if the post flair contains nothing flair gets set to nothing.
if(isset($_POST['stackid'])&&isset($_POST['flair'])&&is_numeric($_POST['stackid'])){
    session_start();
    if(isset($_SESSION['admin'])&&$_SESSION['admin']==1){
        include_once "../connect.php";
        $banner = mysqli_real_escape_string($con, $_POST['flair']);
        $id = mysqli_real_escape_string($con, $_POST['stackid']);
        if($banner==""||!isset($banner)){
            mysqli_query($con, "UPDATE stacks SET stackflair = '' WHERE stack_id = $id");
            mysqli_query($con, "UPDATE users SET flair = '' WHERE stack_id = $id");
        }else{
            mysqli_query($con, "UPDATE stacks SET stackflair = '$banner' WHERE stack_id = $id");
            mysqli_query($con, "UPDATE users SET flair = '$banner' WHERE stack_id = $id");
        }
        echo "https://stacksity.com/stack.php?id=".$id;
    }else{
        echo "1";
    }
}else{
    echo "1";
}