<?php
require_once("head.php");
require_once "Parsedown.php";
require_once "notification.php";
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
if(isset($_SESSION['user_id'])&&isset($_POST["postid"])&&isset($_POST["text"])){

    include_once "connect.php";

    $d['delete'] = true;
    $postid = mysqli_real_escape_string($con, $_POST["postid"]);
    $u_id = $_SESSION['user_id'];
    $content = $_POST["text"]." ";
    if(strlen($content)>40000){
        die('5');
    }
    if($content==''){
        die('8');
    }

    //$content = convert_accent($content);

//    purifies the comment to prevent injections
//    $config = HTMLPurifier_Config::createDefault();
//    $purifier = new HTMLPurifier($config);
//    $content = $purifier->purify($content);
    $raw = $content;

    //processString turns all stacks to links
    $content = htmlspecialchars($content);
    $content = processString($content);
    $unotequery;

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
                    $unotequery[] = $row['user_id'];
                    //mysqli_query($con, $notequery) or die("9");
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
    $userstack = mysqli_real_escape_string($con, $_SESSION['stack_id']);
    $username = mysqli_real_escape_string($con, $_SESSION['username']);

//  This section of code is used for the scrambler account to randomize accounts to post from, drawing from an array.
    if($u_id == 4409){
        $fakenames = array("lasers","pleasenofap","hellohello","justathing","whyisthis","asdf","egg","MarkZuckerberg","stevejobs","nojobsforsteve","unicorns","Willispls","erero7","moderator","sssadasd","supremeleader","malphiteisOP","APShacoMid","imgoingtohellforthis","Ilikefood","gamerguy","milspec","newsguy","abcdefg","kimjongun","scrambler","obama","kanye","putin");
        $random = mysqli_real_escape_string($con, strtoupper($fakenames[array_rand($fakenames)]));

        $namesql = mysqli_query($con, "SELECT username, user_id, stack_id FROM users WHERE UPPER(username) = '".$random."' LIMIT 1");
        while($row = mysqli_fetch_assoc($namesql)){
            $u_id = mysqli_real_escape_string($con, $row["user_id"]);
            $userstack = mysqli_real_escape_string($con, $row["stack_id"]);
            $username = mysqli_real_escape_string($con, $row["username"]);
        }
    }

    if(isset($_POST['commentid'])){
        $sql = mysqli_query($con, "INSERT INTO comments (post_id, user_id, user_stack, content, raw, link_id, depth)
        VALUES ('".$postid."','".$u_id."', '$userstack', '".$content."', '".$raw."','".$_POST['commentid']."', 1 )");
    }else{
        $sql = mysqli_query($con, "INSERT INTO comments (post_id, user_id, user_stack, content, raw)
        VALUES ('".$postid."','".$u_id."', '$userstack', '".$content."', '".$raw."')");
    }
    if($sql){
        $cid = mysqli_insert_id($con);

        $d['comment_id'] = $cid;
        $d['raw'] = $raw;
        $d['user_id'] = $u_id;
        $d['username'] = $username;
        $d['depth'] = 0;
        $d['downstacks'] = 0;
        $d['upstacks'] = 1;
        $d['vote'] = 2;
        $d['flair'] = "";
        $d['created'] = "0 seconds ago";
        $d['user_stack'] = $userstack;

        ob_end_clean();
        header("Connection: close");
        ignore_user_abort(true); // just to be safe
        ob_start();

        echo json_encode($d);

        $size = ob_get_length();
        header("Content-Length: $size");
        ob_end_flush(); // Strange behaviour, will not work
        flush();

//        echo json_encode($d);

        mysqli_query($con, "INSERT INTO commentvote (comment_id, user_id, vote_type) VALUES ( '".$cid."' , '$u_id',  2)") or die('1');
        mysqli_query($con, "UPDATE posts SET comments = comments+1 WHERE post_id = '$postid' ") or die('3');

        if(isset($unotequery)){
            foreach ($unotequery as $rowid) {
                mysqli_query($con, "INSERT INTO notifications (from_user, to_user, note_type, link, commentlink, note_time) VALUES ('$u_id', $rowid, '3', '".$postid."', $cid, UNIX_TIMESTAMP(now()))");
                $message = $username." tagged you in a comment";
                notification($message, $rowid);
            }
        }
        if(!isset($_POST['commentid'])){
            $checkuser = mysqli_query($con, "SELECT user_id FROM posts WHERE post_id = '".$_POST['postid']."'");
            while($row = mysqli_fetch_assoc($checkuser)){
                $user_id = $row["user_id"];
                if($user_id != $u_id){
                    $notequery = "INSERT INTO notifications (from_user, to_user, note_type, link, commentlink, note_time) VALUES ('$u_id', $user_id, '1', '".$_POST['postid']."', $cid, UNIX_TIMESTAMP(now()))";
                    mysqli_query($con, $notequery) or die("9");
                    $message = $username." commented on your post";
                    notification($message, $user_id);
                }
            }
        }else{
            $checkuser = mysqli_query($con, "SELECT user_id FROM comments WHERE comment_id = '".$_POST['commentid']."'");
            while($row = mysqli_fetch_assoc($checkuser)){
                $user_id = $row["user_id"];
                if($user_id != $u_id){
                    $notequery = "INSERT INTO notifications (from_user, to_user, note_type, link, commentlink, note_time) VALUES ('$u_id', $user_id, '2', '".$_POST['postid']."', $cid, UNIX_TIMESTAMP(now()))";
                    mysqli_query($con, $notequery) or die("9");
                    $message = $username." replied to your comment";
                    notification($message, $user_id);
                }
            }
        }
    }else{
        echo('2');
    }
}
