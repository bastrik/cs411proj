<?php
//ini_set("SMTP","smtp.stacksity.com" );
//ini_set('sendmail_from', 'support@stacksity.com');
require_once("head.php");
if(isset($_POST['resetemail'])){
    if(isset($_POST['g-recaptcha-response'])) {
        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $data = array('secret' => '6LfZ5QMTAAAAADvGvVhmG6sIX5IgXYKml0KD_jv9', 'response' => $_POST['g-recaptcha-response']);
        // use key 'http' even if you send the request to https://...
        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data),
            ),
        );
        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        if(strpos($result,'false')!==false){
            die("4");
        }
    }

    include_once("connect.php");

    $email = mysqli_real_escape_string($con,strtoupper($_POST['resetemail']));
    $sql = mysqli_query($con, "SELECT * FROM users WHERE UPPER(email) = '".$email."' LIMIT 1");
    if(mysqli_num_rows($sql)==0){
        die ("2");
    }else{
        while($row = mysqli_fetch_assoc($sql)){
            $uid = $row['user_id'];
            $token = md5(sha1(md5($row['username']+$uid+time())));
            $token = mysqli_real_escape_string($con, $token);
            $expire = time() + 60*60;
            $query = mysqli_query($con,"INSERT INTO password_tokens (token, expire_time, user_id) VALUES ('$token','$expire','$uid')");
            if($query){
                $email = $row['email'];
                $to = $email;
                $subject = "Stacksity - Password Reset";
                $name = $row["username"];
                $link = "https://stacksity.com/reset.php?id=".$token;

                $message = '
                            <h1>Hi '.$name.'!</h1>
                            <p>There\'s been a password change request for your Stacksity account.</p>
                            <p>If this was you, you can set a new password within an hour of receiving this email.<br><br></p>

                            <p><a href="'.$link.'">'.$link.'</a></p>

                            <p><br>To keep your account secure, please don\'t forward this email to anyone, and please do not reply to this email.<br><br>Thanks!<br>-Stacksity</p>';

                $from = "support@stacksity.com";
                $headers = "From: $from\r\n";
                $headers .= "Content-type: text/html\r\n";
                mail($to,$subject,$message,$headers);
                echo ("3");
            }else{
                echo ("1");
            }
        }
    }
}else{
    die ("0");
}
