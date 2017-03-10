<?php
/**
 * Created by PhpStorm.
 * User: killswitch
 * Date: 8/18/2015
 * Time: 4:16 PMgfhdhgfd
 */

if(isset($_COOKIE['collapse'])){
    unset($_COOKIE['collapse']);
    setcookie('collapse', null, -1,"/");
    echo "0";
}else{
    $time = (10 * 365 * 24 * 60 * 60);
    setcookie(
        "collapse",
        true,
        time() + $time,
        "/"

    );
    echo "1";
}
