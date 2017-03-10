<?php
require_once("head.php");
require_once "Parsedown.php";
require_once 'library/HTMLPurifier.auto.php';

function processString($s) {
    $s = nl2br($s);
    $s = preg_replace('/(^|\s)(\$[A-Za-z0-9_-]+)/', '$1<a href="/$2">$2</a>', $s);
    //$s = preg_replace('/https?:\/\/[\w\-\.!~#?&=+\*\'"(),\/]+/','<a href="$0">$0</a>',$s);
    return $s;
}
function convert_accent($string)
{
    return htmlentities($string, ENT_COMPAT, 'UTF-8');
}
if(isset($_POST['session_id'])){
    session_id($_POST['session_id']);
}
session_start();
if(isset($_SESSION['user_id'])&&isset($_POST["text"])&&isset($_POST['commentid'])){

    include_once "connect.php";

    $d['delete'] = true;
    $commentid = mysqli_real_escape_string($con, $_POST["commentid"]);
    $u_id = $_SESSION['user_id'];
    $content = $_POST["text"]." ";
    $commentid = $_POST['commentid'];
    if(strlen($content)>40000){
        die('5');
    }
    if($content==''){
        die('8');
    }
    //$content = convert_accent($content);

    //purifies the comment to prevent injections
    $config = HTMLPurifier_Config::createDefault();
    $purifier = new HTMLPurifier($config);
    $content = $purifier->purify($content);
    $raw = $content;

    //processString turns all stacks to links
    $content = processString($content);

    //this block of code is notifications and stores it in the notification table
    if (preg_match_all('/(^|\s)\@([\S]+)/', $content, $matches))
    {
        $users = array_unique($matches[2], SORT_STRING);
        // $users should now contain array: ['SantaClaus', 'Jesus']
        foreach ($users as $user) {
            $user = mysqli_real_escape_string($con, $user);
            if(strlen($user) < 33){
                $getuser = mysqli_query($con, "SELECT user_id, stack_id FROM users WHERE UPPER(username) = '".strtoupper($user)."' LIMIT 1") or die("4");
                while($row = mysqli_fetch_assoc($getuser)){
                    $content = str_replace("@".$user." ","<a href='/u/".$row['stack_id']."'>@".$user."</a> ",$content);
                }
            }
        }
    }
    $parsedown = new Parsedown();
    $content = $parsedown->text($content);
    $d['content'] = $content;
    $content = mysqli_real_escape_string($con, $content);
    $raw = mysqli_real_escape_string($con, $raw);
    $commentid = $_POST['commentid'];

    if(isset($_POST['commentid'])){
        $sql = mysqli_query($con, "UPDATE comments SET content = '$content', raw = '$raw', edit = now() WHERE comment_id = $commentid");
        echo $d['content'];
    }
}
