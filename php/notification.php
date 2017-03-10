<?php
require_once("head.php");
// Push The notification with parameters
require_once('PushBots.class.php');
function notification($msg, $id) {
    $pb = new PushBots();
// Application ID
    $appID = '561ed24517795902148b4569';
// Application Secret
    $appSecret = '3f11ffd53bfe1a9945cdc09e6210a784';
    $pb->App($appID, $appSecret);

// Notification Settings
    $pb->Alert($msg);
    $pb->Platform(array("0","1"));
    $pb->Alias($id);
// Push it !
    $pb->Push();
}

//if(isset($_POST["message"])&&isset($_POST["id"])){
//    notification($_POST["message"], $_POST["id"]);
//}
?>
