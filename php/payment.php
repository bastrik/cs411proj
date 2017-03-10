<?php
require_once("head.php");
function cryptPass($input, $rounds = 7)
{
    $salt = "";
    $saltChars = array_merge(range('A', 'Z'), range('a', 'z'), range(0, 9));
    for ($i = 0; $i < 22; $i++) {
        $salt .= $saltChars[array_rand($saltChars)];
    }
    return crypt($input, sprintf('$2y$%02d$', $rounds) . $salt);
}
$username=$_POST['username'];
$email=$_POST['email'];
$password=$_POST['password'];

function validate_alphanumeric_underscore($str)
{
    return preg_match('/^[a-zA-Z0-9_]+$/',$str);
}

if(!(empty($username)||empty($email)||empty($password))){

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
    include_once "connect.php";

    if(preg_match('/\s/',$username)){
        die('10');
    }
    if($username[0]=='$'){
        die('11');
    }
    if(is_numeric($username)){
        die('12');
    }
    if(!validate_alphanumeric_underscore($username)){
        die("13");
    }

    if(strlen($email)>254){
        $email = substr($email, 0, 254);
    }
    $email = strtolower($email);
    $email = mysqli_real_escape_string($con, $email);;

    $sql = mysqli_query($con, "SELECT 1 FROM users WHERE email='".$email."'") or die("4");

    if(mysqli_num_rows($sql)>0)
    {
        echo("1");
    }
    else
    {
        if(strlen($username)>32){
            $username = substr($username, 0, 32);
        }
        $username = mysqli_real_escape_string($con, $username);
        $sqll = mysqli_query($con, "SELECT * FROM users WHERE UPPER(username) = UPPER('".$username."')") or die("6");
        if(mysqli_num_rows($sqll)>0)
        {
            echo("2");
        }
        else
        {
            if(strlen($password)>16){
                $password = substr($password, 0, 16);
            }

            $password = cryptPass($password);
            $password = mysqli_real_escape_string($con,$password);

            mysqli_query($con, "INSERT INTO stacks (stackname) VALUES ('".$username."')") or die("8");
            $stack_id = intval(mysqli_insert_id($con));

            mysqli_query($con, "INSERT INTO users (username, email, password, stack_id) VALUES ('".$username."','".$email."','".$password."', $stack_id)") or die("7");
            $user_id = intval(mysqli_insert_id($con));

            mysqli_query($con,'INSERT INTO follow (user_id, stack_id, following) VALUES ( "'.$user_id.'", "'.$stack_id.'", TRUE )');
            mysqli_query($con,'INSERT INTO follow (user_id, stack_id, following) VALUES ( "'.$user_id.'", 6, TRUE )');
            mysqli_query($con,'INSERT INTO follow (user_id, stack_id, following) VALUES ( "'.$user_id.'", 14, TRUE )');
            mysqli_query($con,'INSERT INTO follow (user_id, stack_id, following) VALUES ( "'.$user_id.'", 959, TRUE )');
            mysqli_query($con,'INSERT INTO follow (user_id, stack_id, following) VALUES ( "'.$user_id.'", 15, TRUE )');
            mysqli_query($con,'INSERT INTO follow (user_id, stack_id, following) VALUES ( "'.$user_id.'", 16, TRUE )');
            mysqli_query($con,'INSERT INTO follow (user_id, stack_id, following) VALUES ( "'.$user_id.'", 17, TRUE )');
            mysqli_query($con,'INSERT INTO follow (user_id, stack_id, following) VALUES ( "'.$user_id.'", 19, TRUE )');
            mysqli_query($con,'INSERT INTO follow (user_id, stack_id, following) VALUES ( "'.$user_id.'", 20, TRUE )');
            mysqli_query($con,'INSERT INTO follow (user_id, stack_id, following) VALUES ( "'.$user_id.'", 21, TRUE )');
            mysqli_query($con,'INSERT INTO follow (user_id, stack_id, following) VALUES ( "'.$user_id.'", 42, TRUE )');
            mysqli_query($con,'INSERT INTO follow (user_id, stack_id, following) VALUES ( "'.$user_id.'", 74, TRUE )');
            mysqli_query($con,'INSERT INTO follow (user_id, stack_id, following) VALUES ( "'.$user_id.'", 516, TRUE )');
            mysqli_query($con,'INSERT INTO follow (user_id, stack_id, following) VALUES ( "'.$user_id.'", 651, TRUE )');
            mysqli_query($con,'INSERT INTO follow (user_id, stack_id, following) VALUES ( "'.$user_id.'", 803, TRUE )');
            mysqli_query($con,'INSERT INTO follow (user_id, stack_id, following) VALUES ( "'.$user_id.'", 1786, TRUE )');
            mysqli_query($con,'INSERT INTO follow (user_id, stack_id, following) VALUES ( "'.$user_id.'", 897, TRUE )');
            mysqli_query($con,'INSERT INTO follow (user_id, stack_id, following) VALUES ( "'.$user_id.'", 599, TRUE )');
            mysqli_query($con,'INSERT INTO follow (user_id, stack_id, following) VALUES ( "'.$user_id.'", 55, TRUE )');
            mysqli_query($con,'INSERT INTO follow (user_id, stack_id, following) VALUES ( "'.$user_id.'", 54, TRUE )');
            mysqli_query($con,'INSERT INTO follow (user_id, stack_id, following) VALUES ( "'.$user_id.'", 1529, TRUE )');
            mysqli_query($con,'UPDATE stacks SET followers = followers + 1 WHERE stack_id IN (6, 14, 959,15,55,16,17,19,20,21,42, 74, 516, 599, 803, 1786, 897, 1529)');
            echo('3');
        }
    }
}else {
    echo('69');
}
