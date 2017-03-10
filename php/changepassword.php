<?php
require_once("head.php");
/**
 * Created by PhpStorm.
 * User: killswitch
 * Date: 4/13/2015
 * Time: 11:15 PM
 */
function cryptPass($input, $rounds = 7){
    $salt="";
    $saltChars = array_merge(range('A','Z'), range('a','z'), range(0,9));
    for($i = 0; $i<22; $i++){
        $salt .= $saltChars[array_rand($saltChars)];
    }
    return crypt($input, sprintf('$2y$%02d$', $rounds).$salt);
}
session_start();
if(isset($_POST['password'])&&isset($_SESSION['reset_id'])){
    $password = cryptPass($_POST['password']);
    $uid = $_SESSION['reset_id'];

    include_once "connect.php";
    $password = mysqli_real_escape_string($con,$password);
    $sql = mysqli_query($con, "UPDATE users SET password = '$password' WHERE user_id = '$uid'");
    if($sql){
        if(isset($_SESSION['user_id'])){
            echo '3';
        }else{
            echo '2';
        }
        $_SESSION['reset_id']=null;
    }else{
        echo "1";
    }
}else{
    echo "0";
}
