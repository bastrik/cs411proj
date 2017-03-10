<?php
require_once("head.php");
require_once "Parsedown.php";
require_once "notification.php";
if(isset($_POST['session_id'])){
    session_id($_POST['session_id']);
}
session_start();
if(isset($_SESSION['user_id'])&&isset($_POST["stack"])&&isset($_POST["title"])&&isset($_POST["type"])&&(isset($_POST["user_value"]))&&(isset($_POST["link"])||isset($_POST["text"]))){

    $private = 0;
    if(isset($_POST['setprivate'])&&$_POST['setprivate']=="1"){
        $private = 1;
    }
    include_once "connect.php";

    $is_user = $_POST["user_value"];

    if(!(($is_user==0)||($is_user==1))){
        die('3');
    }
    $stackname = $stack;
    $sprivate = 0;
    if($private == 1){
        if($is_user==1){
            $d['private'] = $private;
        }else{
            $private = 0;
            $d['private'] = $private;
            $sprivate = 1;
        }
    }

    $u_id = mysqli_real_escape_string($con, $_SESSION['user_id']);
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

    $_POST["title"] =  convert_accent($_POST["title"]);
    $d['title'] = $_POST["title"];
    $d['delete'] = true;
    $d['flair'] = "";
    $d['stackflair'] = "";
    $d['report'] = 1;
    $title = mysqli_real_escape_string($con, $_POST["title"]);
    $posttype = mysqli_real_escape_string($con, $_POST["type"]);
    $stack = mysqli_real_escape_string($con, $_POST["stack"]);
    $nsfw = 0;
    if(isset($_POST['nsfw'])&&is_numeric($_POST['nsfw'])){
        $nsfw = mysqli_real_escape_string($con, $_POST["nsfw"]);
    }

    if($stack == "0" || $stack=="-1"){
        $stack = mysqli_real_escape_string($con, $userstack);
    }else{
        $stack = mysqli_real_escape_string($con, $_POST["stack"]);
    }

    $getstacks = mysqli_query($con, "SELECT stackname, nsfw FROM stacks WHERE stack_id = '".$stack."' LIMIT 1") or die("2");
    $exist = false;
    while($row = mysqli_fetch_assoc($getstacks)){
        $exist = true;
        if($row["nsfw"]==1){
            if($nsfw==0) $nsfw = 1;
        }
        $stackname = $row["stackname"];
    }
    if(!$exist){ die("2");};
    $d['nsfw'] = $nsfw;

    //if the type of post is a link of some form (images, videos included)
    if($posttype == 0){
        $link = $_POST["link"];
        if($link == ''){
            die('4');
        }
        if(strpos($link, 'http')===false){
            $link = "https://".$link;
        }
        if(filter_var($link, FILTER_VALIDATE_URL, FILTER_FLAG_HOST_REQUIRED)){
            if(preg_match('/\.(png|jpg|gif|jpeg)$/', $link)){
                $posttype = 2;
                $embed = '<img src="'.$link.'" class="imagecon">';
            }else{
                $url = "http://api.embed.ly/1/oembed?key=4ddec71d093c4a2c8ae11973cbac88e7&url=".stringToHex($link);

                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_HEADER, false);
                $data = curl_exec($curl);
                curl_close($curl);

                $json = json_decode($data, true);

                $content; $image;
                if(empty($json['description'])){
                    $content = "[".$json['provider_name']."] ".$link;
                }else{
                    $content = "[".$json['provider_name']."] ".$json['description'];
                    if(strlen($content)>100){
                        $content = substr($content, 0, 100)."...";
                    }
                }
                $embed = 0;
                if($json['type']=="photo"){
                    $posttype = 2;
                    $link = $json['url'];
                    if(!isset($json['html'])||$json['html']==''){
                        if(preg_match('/\.(png|jpg|gif|jpeg)/i', $json['url'])){
                            $embed = '<img src="'.$json['url'].'" class="imagecon">';
                        }else{
                            $posttype = 0;
                        }
                    }else{
                        $embed = $json['html'];
                    }
                }else if($json['type']=="video"||$json['type']=="rich"){
//                    if(endsWith($link,".webm")){
//                        $embed = '<video autoplay="" loop="" muted="" preload="" style="width: 100%">
//                        <source src="'.preg_replace('/webm$/',"mp4",$link).'" type="video/mp4">
//                        <source src="'.$link.'" type="video/webm">
//                    </video>';
//                        $posttype = 3;
//                    }else if(endsWith($link,".gifv")){
//                        $embed = '<video autoplay="" loop="" muted="" preload="" style="width: 100%">
//                                    <source src="'.preg_replace('/gifv$/',"mp4",$link).'" type="video/mp4">
//                                    <source src="'.preg_replace('/gifv$/',"webm",$link).'" type="video/webm">
//                                </video>';
//                    $posttype = 3;}
//                    if($json['provider_name']=='gfycat'){
//                        $url = "http://gfycat.com/cajax/get/".substr($link, strrpos($link, '/') + 1);
//                        $curl = curl_init();
//                        curl_setopt($curl, CURLOPT_URL, $url);
//                        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
//                        curl_setopt($curl, CURLOPT_HEADER, false);
//                        $gfydata = curl_exec($curl);
//                        curl_close($curl);
//
//                        $gfyjson = json_decode($gfydata, true);
//                        $embed = '<video autoplay="" loop="" muted="" preload="" style="width: 100%">
//                            <source src="'.$gfyjsonp["gfyItem"]["mp4Url"].'" type="video/mp4">
//                            <source src="'.$gfyjson["gfyItem"]["webmUrl"].'" type="video/webm">
//                        </video>';
//                        $posttype = 3;
//                    }else
                    if($json['html']==''){
                        $posttype = 0;
                    }else{
                        $embed = $json['html'];
                        $posttype = 3;
                    }
                }
            }
//              else if(preg_match('/\.(webm)/i', $json['url'])){
//                $embed = '<video autoplay="" loop="" muted="" preload="" style="width: 100%">
//					<source src="'.$json['url'].'" type="video/webm">
//					<source src="'.preg_replace('/webm$/',"mp4",$json['url']).'" type="video/mp4">
//				</video>';
//                $posttype = 3;
//            }else if(endsWith($json['url'],"gifv")){
//                $embed = '<video autoplay="" loop="" muted="" preload="" style="width: 100%">
//					<source src="'.preg_replace('/gifv$/',"webm",$json['url']).'" type="video/webm">
//					<source src="'.preg_replace('/gifv$/',"mp4",$json['url']).'" type="video/mp4">
//				</video>';
//                $posttype = 3;
//            }
            $embed = str_replace("src=\"//","src=\"https://",$embed);
            $embedescaped = mysqli_real_escape_string($con, $embed);
            if(empty($json["thumbnail_url"])){
                $image = 'https://stacksity.com/img/post/thumb.jpg';
            }else{
                $image = $json["thumbnail_url"];
            }
            //$d['text'] = convert_accent($content);
            $d['image'] = $image;
            $d['link'] = $link;
            $content = mysqli_real_escape_string($con, $content);
            $image = mysqli_real_escape_string($con, $image);
            $link = mysqli_real_escape_string($con, $link);
            $d['text'] = convert_accent($content);

            //checks for geolocation settings
            if(isset($_COOKIE["nearbyoff"])||!(isset($_POST["lat"])&&isset($_POST["long"]))){
                $sql = mysqli_query($con, "INSERT INTO posts (user_id, title, posttype, link, text, stack_id, poster_id, image, embed, private, nsfw)
                  VALUES ('".$u_id."','".$title."','".$posttype."','".$link."','".$content."','".$stack."','".$userstack."','".$image."', '$embedescaped', $private, $nsfw)");
            }else{
                $latitude = mysqli_real_escape_string($con, $_POST["lat"]);
                $longitude = mysqli_real_escape_string($con, $_POST["long"]);
                $sql = mysqli_query($con, "INSERT INTO posts (user_id, title, posttype, link, text, stack_id, poster_id, image, embed, private, nsfw, latitude,longitude)
                  VALUES ('".$u_id."','".$title."','".$posttype."','".$link."','".$content."','".$stack."','".$userstack."','".$image."', '$embedescaped', $private, $nsfw, $latitude,$longitude)");
            }

            if($sql){
                $pid = mysqli_insert_id($con);

                //echos the contents in the form of a JSON file
                $d['post_id'] = $pid;
                $d['username'] = $username;
                $d['stackflair'] = "";
                $d['user_id'] = $u_id;
                $d['posttype'] = $posttype;
                $d['stack_id'] = $stack;
                $d['poster_id'] = $userstack;
                $d['downstacks'] = 0;
                $d['upstacks'] = 1;
                $d['vote'] = 2;
                $d['comments'] = 0;
                $d['created'] = "0 seconds ago";
                $d['stackname'] = $stackname;
                $d['embed'] = $embed;

                ob_end_clean();
                header("Connection: close");
                ignore_user_abort(true); // just to be safe
                ob_start();

                echo json_encode($d);

                $size = ob_get_length();
                header("Content-Length: $size");
                ob_end_flush(); // Strange behaviour, will not work
                flush();

                mysqli_query($con, "INSERT INTO votes (user_id, post_id, vote_type) VALUES ( '".$u_id."' , '$pid' , 2)") or die('1');
                if($is_user==1&&$userstack!=$stack){

                    //This whole query inside a query thing is so that you can get the ID of the user you are posting to and send him a push notification
                    $useridquery = mysqli_query($con, "SELECT user_id FROM users WHERE stack_id = '$stack'");
                    if($useridquery){
                        while($row = mysqli_fetch_assoc($useridquery)){
                            $notequery = "INSERT INTO notifications (from_user, to_user, note_type, link, note_time) VALUES ('".$u_id."', '".$row["user_id"]."', '0', '$pid', UNIX_TIMESTAMP(now()))";
                            mysqli_query($con, $notequery) or die("9");

                            //message sent to mobile device to display as notification
                            if($posttype==2){
                                $type = "photo";
                            }else if($posttype==3){
                                $type = "video";
                            }else{
                                $type = "link";
                            }
                            $message = $username." posted a ".$type." to your stack";
                            notification($message, $row["user_id"]);
                        }
                    }
                }
            }else{
                echo('2');
            }
        }else{
            die('3');
        }
    //if the type of post is text
    }elseif($posttype == 1){
        $content = $_POST["text"]." ";
        if(strlen($content)>40000){
            die('5');
        }
        if($content==''){
            die('8');
        }
//        $content = emoji_softbank_to_unified($content);
        $content = convert_accent($content);
        $content = processString($content);
        $unotequery;

        //This part parses through the text and checks for tags and finds the info of the user tagged
        if (preg_match_all('/(^|\s)\@([\S]+)/', $content, $matches))
        {
            $users = array_unique($matches[2], SORT_STRING);
            // $users should now contain array: ['SantaClaus', 'Jesus']
            foreach ($users as $user) {
                $user = mysqli_real_escape_string($con, $user);
                if(strlen($user)<33){
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
        $d['text'] = $content;
        $content = mysqli_real_escape_string($con, $content);
//        $content = emoji_unified_softbank($content);
        //checks for geolocation settings
        if(isset($_COOKIE["nearbyoff"])||!(isset($_POST["lat"])&&isset($_POST["long"]))){
            $sql = mysqli_query($con, "INSERT INTO posts (user_id, title, posttype, text, stack_id, poster_id, private, nsfw)
        VALUES ('".$u_id."','".$title."','".$posttype."','".$content."','".$stack."','".$userstack."', $private, $nsfw)");
        }else{
            $latitude = mysqli_real_escape_string($con, $_POST["lat"]);
            $longitude = mysqli_real_escape_string($con, $_POST["long"]);
            $sql = mysqli_query($con, "INSERT INTO posts (user_id, title, posttype, text, stack_id, poster_id, private, nsfw, latitude, longitude)
            VALUES ('".$u_id."','".$title."','".$posttype."','".$content."','".$stack."','".$userstack."', $private, $nsfw, $latitude, $longitude)");
        }

        if($sql){
            $pid = mysqli_insert_id($con);

            //echos the contents in the form of a JSON file
            $d['post_id'] = $pid;
            $d['username'] = $username;
            $d['user_id'] = $u_id;
            $d['posttype'] = $posttype;
            $d['stack_id'] = $stack;
            $d['poster_id'] = $userstack;
            $d['downstacks'] = 0;
            $d['upstacks'] = 1;
            $d['vote'] = 2;
            $d['created'] = "0 seconds ago";
            $d['comments'] = 0;
            $d['stackname'] = $stackname;

            ob_end_clean();
            header("Connection: close");
            ignore_user_abort(true); // just to be safe
            ob_start();

            echo json_encode($d);

            $size = ob_get_length();
            header("Content-Length: $size");
            ob_end_flush(); // Strange behaviour, will not work
            flush();

            if(isset($unotequery)){
                foreach ($unotequery as $rowid) {
                    mysqli_query($con, "INSERT INTO notifications (from_user, to_user, note_type, link, note_time) VALUES ('".$u_id."', '".$rowid."', '4', '".$pid."', UNIX_TIMESTAMP(now()))") or die("9");

                    //message sent to mobile device to display as notification
                    $message = $username." tagged you in a post";
                    notification($message, $rowid);
                }
            }
            mysqli_query($con, "INSERT INTO votes (user_id, post_id, vote_type) VALUES ( '".$u_id."' , '$pid' , 2)") or die('1');
            if($is_user==1&&$userstack!=$stack){
                //This whole query inside a query thing is so that you can get the ID of the user you are posting to and send him a push notification
                $useridquery = mysqli_query($con, "SELECT user_id FROM users WHERE stack_id = '$stack'");
                if($useridquery){
                    while($row = mysqli_fetch_assoc($useridquery)){
                        $notequery = "INSERT INTO notifications (from_user, to_user, note_type, link, note_time) VALUES ('".$u_id."', '".$row["user_id"]."', '0', '$pid', UNIX_TIMESTAMP(now()))";
                        mysqli_query($con, $notequery) or die("9");

                        //message sent to mobile device to display as notification
                        $message = $username." wrote on your stack";
                        notification($message, $row["user_id"]);
                    }
                }
            }
        }else{
            echo('2');
        }
    }else{
        die('3');
    }

}else{
//    echo(isset($u_id)&&isset($_POST["stack"])&&isset($_POST["title"])&&isset($_POST["type"])&&(isset($_POST["user_value"]))&&(isset($_POST["link"])||isset($_POST["text"])));
    echo "not set";
}
function stringToHex($string) {
    $hexString = '';
    for ($i=0; $i < strlen($string); $i++) {
        $hexString .= '%' . bin2hex($string[$i]);
    }
    return $hexString;
}
function processString($s) {
    $s = nl2br($s);
    $s = preg_replace('/(^|\s)(\$[A-Za-z0-9_-]+)/', '$1<a href="/$2">$2</a>', $s);
    //$s = preg_replace('/https?:\/\/[\w\-\.!~#?&=+\*\'"(),\/]+/','<a href="$0">$0</a>',$s);
    return $s;
}
function convert_accent($string)
{
    return htmlspecialchars($string);
}
function endsWith($haystack, $needle) {
    // search forward starting from end minus needle length characters
    return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== FALSE);
}
