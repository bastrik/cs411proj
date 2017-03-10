<?php
if(isset($_POST['stackid'])&&is_numeric($_POST['stackid'])){
    session_start();
    if(isset($_SESSION['admin'])&&$_SESSION['admin']==1){
        include_once "../connect.php";
        $id = mysqli_real_escape_string($con, $_POST['stackid']);
        mysqli_query($con, "UPDATE stacks SET nsfw = NOT nsfw WHERE stack_id = $id");
        echo "https://stacksity.com/stack.php?id=".$id;
    }else{
        echo "1";
    }
}else{
    echo "1";
}