<?php
/**
 * Created by PhpStorm.
 * User: killswitch
 * Date: 8/18/2015
 * Time: 4:16 PM
 */

if(isset($_COOKIE['night'])){
    unset($_COOKIE['night']);
    setcookie('night', null, -1,"/");
    echo "0";
}else{
    $time = (10 * 365 * 24 * 60 * 60);
    setcookie(
        "night",
        true,
        time() + $time,
        "/"

    );
    echo "1";
}