<?php
if(isset($_POST['stackid'])&&isset($_POST['desc'])&&is_numeric($_POST['stackid'])){
    session_start();
    if(isset($_SESSION['admin'])&&$_SESSION['admin']==1){
        include_once "../connect.php";
        $id = mysqli_real_escape_string($con, $_POST['stackid']);
        $desc = mysqli_real_escape_string($con, $_POST['desc']);
        mysqli_query($con, "UPDATE stacks SET stack_desc = '$desc' WHERE stack_id = $id");
        echo "https://stacksity.com/stack.php?id=".$id;
    }else{
        echo "1";
    }
}else{
    echo "1";
}