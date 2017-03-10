<?php
require_once("head.php");
session_start();
include_once "checklogin.php";
$login = isset($_SESSION['user_id']);
$stack = 1;
$stacks = false;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Stacksity | Post Not Visible</title>
    <meta name="description" content="This post does not exist or is private">
    <meta name="viewport" content="width=device-width, minimal-ui, initial-scale=1, maximum-scale=1, user-scalable=no"/>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" href="/img/favicon.ico">
    <meta property="og:image" content="/img/ms-icon-310x310.png">
    <meta name="twitter:image" content="/img/ms-icon-310x310.png">
    <meta itemprop="image" content="/img/ms-icon-310x310.png">
    <link rel="shortcut icon" href="/img/favicon.ico">
    <link rel="apple-touch-icon" sizes="57x57" href="/img/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/img/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/img/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/img/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/img/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/img/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/img/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/img/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/img/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="/img/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/img/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/img/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/img/favicon-16x16.png">
    <link rel="manifest" href="/img/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/img/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="description" content="Talk issues, read news, or just find something funny from nearby or from the world on Stacksity, there's a stack for anything so come find it.">
    <meta name="keywords" content="Stacksity, stack, stacks, social network, vote, topstack, university" />
    <meta name="author" content="Tyler Han"/>
    <meta name="distribution" content="global"/>
    <meta http-equiv="content-language" content="en-us"/>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">

    <link rel="stylesheet" href="../css/style.css">
    <?if(isset($_COOKIE["night"])&&$_COOKIE['night']>0){
        echo '<link rel="stylesheet" href="../css/nightmode.css">';
    }?>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<? include_once 'header.php';?>
<div class="headergap"></div>
<div class="center margintop">
    <h1 style="text-align:center">This post doesn't seem to exist :( </h1>
    <h4 style="text-align:center; display: block">It's either deleted, private, or nonexistent <span class="glyphicon glyphicon-thumbs-down"></span> </h4>
    <img src="../img/background.png" style="width: 60%; margin:20px auto; display: block"/>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<? if($login) echo '<script src="/js/notification.js"></script>'; ?>
</body>
</html>
