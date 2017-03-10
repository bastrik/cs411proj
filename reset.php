<?php
/**
 * Created by PhpStorm.
 * User: killswitch
 * Date: 4/13/2015
 * Time: 8:37 PM
 */
session_start();
if(isset($_GET['id'])&&strlen($_GET['id'])<33){
    $id = $_GET['id'];
    include_once "php/connect.php";
    $time = time();
    $sql = mysqli_query($con, "SELECT user_id FROM password_tokens WHERE expire_time > '$time' AND token = '$id' LIMIT 1");
    if(mysqli_num_rows($sql)==1){
        while($row = mysqli_fetch_assoc($sql)){
            $uid = $row['user_id'];

            session_start();
            $_SESSION['reset_id']=$uid;
        }
    }else{
        header("location: not_found.html");
    }
}else if(isset($_SESSION["user_id"])){
    $_SESSION['reset_id']=$_SESSION["user_id"];
}else{
    header("location: not_found.html");
}?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Stacksity | Forgot Password?</title>
    <meta name="viewport" content="width=device-width, minimal-ui, initial-scale=1, maximum-scale=1, user-scalable=no"/>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" href="img/favicon.ico">
    <meta property="fb:app_id" content="">
    <meta property="fb:admins" content="">
    <meta property="og:site_name" content="Stacksity">
    <meta property="og:url" content="https://stacksity.com">
    <meta property="og:type" content="social">
    <meta property="og:title" content="Stacksity">
    <meta property="og:description" content="Stacksity is a social network allowing users to submit and vote on content.">
    <meta property="og:image" content="img/ms-icon-310x310.png">
    <meta property="fb:page_id" content="">
    <meta name="twitter:site" content="">
    <meta name="twitter:title" content="Stacksity">
    <meta name="twitter:description" content="Stacksity is a social network allowing users to submit and vote on content.">
    <meta name="twitter:image" content="img/ms-icon-310x310.png">
    <meta name="apple-itunes-app" content="">
    <meta itemprop="name" content="Stacksity">
    <meta itemprop="description" content="Stacksity is a social network allowing users to submit and vote on content.">
    <meta itemprop="image" content="img/ms-icon-310x310.png">
    <link rel="shortcut icon" href="img/favicon.ico">
    <link rel="apple-touch-icon" sizes="57x57" href="img/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="img/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="img/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="img/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="img/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="img/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="img/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="img/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="img/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="img/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="img/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="img/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="img/favicon-16x16.png">
    <link rel="manifest" href="img/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="img/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="description" content="Stacksity is a social network allowing users to submit and vote on content.">
    <meta name="keywords" content="Stacksity, stack, stacks, social network, vote, topstack, university" />
    <meta name="author" content="Tyler Han"/>
    <meta name="distribution" content="global"/>
    <meta http-equiv="content-language" content="en-us"/>

    <script src='https://www.google.com/recaptcha/api.js'></script>


    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">

    <link rel="stylesheet" href="css/style.css">
    <style>
        .btn-default {
            background: #428bca;
            text-shadow: none;
        }
    </style>
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>

<? $page = 0;
include_once "pageheader.php" ?>
<div class="center">
    <div class="center margintop pass_retrieve">
        <h1>Reset Your Password</h1>
        <form id="passreset" class="form-horizontal margintop">
            <div class="form-group">
                <div class="col-sm-12 pass_reset">
                    <p id="message">Please enter your new password</p>
                    <input name="password" id="inputPassword" type="password" class="form-control" placeholder="new password" required maxlength="32">
                    <p class="margintop">Please re-enter your new password</p>
                    <input type="password" id = "inputPasswordConfirm" class="form-control" placeholder="re-enter password" required maxlength="32">
                </div>
            </div>
            <div class="form-group margintop">
                <div class="col-sm-12">
                    <button type="submit" id="revbutton" class="btn btn-default btn-primary" style="font-weight: normal">Reset Password</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script src="js/passreset.js"></script>
</body>
</html>
