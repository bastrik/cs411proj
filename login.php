<?php
ob_start();
$username=$_POST['inputEm'];
$password=$_POST['inputPass'];

if(!(empty($username)||empty($password))){

    include_once "php/connect.php";

    if(strlen($username)>32){
        $username = substr($username, 0, 32);
    }
    $username = htmlentities($username);
//    $username = strtoupper($username);
    $username = mysqli_real_escape_string($con, $username);;

    $inner="SELECT u.* FROM users u
            WHERE UPPER(username)=UPPER('$username') OR email = '$username' LIMIT 1";
    $result = mysqli_query($con, $inner) or die("4");

    $count=mysqli_num_rows($result);

    // If result matched $myusername and $mypassword, table row must be 1 row
    if($count==1){
        while($row = mysqli_fetch_assoc($result)){

            if(strlen($password)>16){
                $password = substr($password, 0, 16);
            }

            $hashpass = $row['password'];

            if(crypt($password, $hashpass) == $hashpass){

                /*$out="SELECT * FROM stacks WHERE username='$username'";
                $res = mysqli_query($con, $out) or die("9");

                while($stackrow = mysqli_fetch_assoc($res)){
                    setcookie(
                        "stack_id",
                        $stackrow['stack_id'],
                        time() + $time
                    );
                }*/

                if(isset($_SERVER["HTTP_CF_IPCOUNTRY"])){
                    $ip = $_SERVER["HTTP_CF_IPCOUNTRY"];
                }else{
                    $ip = $_SERVER['REMOTE_ADDR'];
                }
//The value of $ip at this point would look something like: "192.0.34.166"
                $ip = ip2long($ip);
//The $ip would now look something like: 1073732954
                if (isset($_POST['checked'])) {
                    $time = (10 * 365 * 24 * 60 * 60);
                    setcookie(
                        "user_id",
                        $row['user_id'],
                        time() + $time
                    );
                    setcookie(
                        "username",
                        $row['username'],
                        time() + $time
                    );
                    setcookie(
                        "logtime",
                        time(),
                        time() + $time
                    );

                    $hash = md5(sha1("!*K".$ip.$row['username'].$row['user_id'].time()."%)d"));
                    setcookie(
                        "hashcheck",
                        $hash,
                        time()+$time
                    );
                    $d['hashcode'] = $hash;
                    $hash = mysqli_real_escape_string($con, $hash);
                }

                $ip = mysqli_real_escape_string($con, $ip);
                if(isset($hash)){
                    $sqlq = "INSERT INTO login( user_id , ip , hash) VALUES('".$row['user_id']."','$ip','$hash')";
                }else{
                    $sqlq = "INSERT INTO login(user_id , ip) VALUES('".$row['user_id']."','$ip')";
                }
                $query = mysqli_query($con,$sqlq);

                session_start();

                $_SESSION['stack_id']=$row['stack_id'];
                $_SESSION['user_id']=$row['user_id'];
                $_SESSION['username']=$row['username'];
                $_SESSION['admin']=$row['admin'];
                $_SESSION['nsfw']=$row['nsfw'];
                $_SESSION['hashcode'] = $hash;

                $d['username'] = $row['username'];
                $d['session_id'] = session_id();
                $d['stack_id'] = $row['stack_id'];
                $d['user_id'] = $row['user_id'];
                echo json_encode($d);
            }else{
                echo "2";
            }
        }
    }
    else {
        echo "1";
    }
}else{
    echo 'pls no';
}
ob_end_flush();