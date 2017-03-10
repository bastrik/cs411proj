<?php
/**
 * Created by PhpStorm.
 * User: killswitch
 * Date: 4/14/2015
 * Time: 5:41 PM
 */
session_start();
include_once "php/checklogin.php";
$login = isset($_SESSION['user_id']);
if(!$login){
    header("location:/\$topstack");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Stacksity | Settings</title>
    <meta name="description" content="Stacksity User Settings, adjust different settings here.">
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
    <meta name="description" content="Stacksity is a social network allowing users to submit and vote on content.">
    <meta name="keywords" content="Stacksity, stack, stacks, social network, vote, topstack, university" />
    <meta name="author" content="Tyler Han"/>
    <meta name="distribution" content="global"/>
    <meta http-equiv="content-language" content="en-us"/>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">

    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/switchery.css">
    <script src="/js/switchery.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <?if(isset($_COOKIE["night"])&&$_COOKIE['night']>0){
        echo '<link rel="stylesheet" href="../css/nightmode.css">';
    }?>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
<!-- Fixed navbar -->
<?
$stack = 1;
$stacks = false;
include_once 'php/header.php'
?>
<div class = "banner settings_banner">
    <div class="center banner-inner">
        <div class="bannertext banner-mid">
            <h1>Settings</h1>
        </div>
    </div>
</div>
    <div class="center margintop">
        <!--toggle on/off NSFW, uses a session value-->
        <div class="opline"><input type="checkbox" id="nsfwbox" class="js-switch" <? if(isset($_SESSION["nsfw"])&&$_SESSION["nsfw"]>0) echo 'checked' ?>/><h2>Not Safe For Work</h2><br><p style="display: inline;">Turn this on if you are over 18 to explore NSFW posts and stacks</p></div>
        <div class="opline"><input type="checkbox" id="collapsebox" class="js-switch" <? if(isset($_COOKIE["collapse"])) echo 'checked' ?>/><h2>Collapse</h2><br><p style="display: inline;">Turn this on to auto-collapse all image, text and video posts</p></div>
        <!--toggle on/off nightmode-->
        <div class="opline"><input type="checkbox" id="nightbox" class="js-switch" <? if(isset($_COOKIE["night"])) echo 'checked' ?>/><h2>Nighttime</h2><br><p style="display: inline;">Turn this on if you need a color scheme better on the eyes</p></div>
        <!--toggle on/off geolocation-->
        <div class="opline"><input type="checkbox" id="geoloc" class="js-switch" <? if(!isset($_COOKIE["nearbyoff"])) echo 'checked' ?>/><h2>Near</h2><br><p style="display: inline;">Turn this on to use your position to make and see nearby posts</p></div>
        <div class="opline"><h2>Biography</h2><br><input id="bio" width="40" type="text" name="bio"/><input id="sub" type="submit"  /><br></div>
        <div class="opline"><a href="reset.php"><h2>Reset Password</h2></a></div>
    </div>
    
    <script>
        function setbio(){
            var text = $("#bio").val();
            $.ajax({
                type     : "POST",
                cache    : false,
                url      : '../php/bio.php',
                data     : { name: text},
                success: function(){
                    alert("Bio set");
                },
                error: function(xhr, status, error) {
                    alert("error"+ xhr.responseText);
                }
            });
        }
    $('#sub').click(function(){
        setbio();
    });
        var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));

        elems.forEach(function(html) {
            var switchery = new Switchery(html);
        });
        $("#nsfwbox").change(function() {
            var checked = document.querySelector('#nsfwbox').checked;
            $.ajax({
                type     : "POST",
                cache    : false,
                url      :  '../php/modnsfw.php',
                data     : "nsfw="+checked,
                success: function(d){
//                  alert($(this)[0].checked)
                },
                error: function(xhr, status, error) {
                    alert("error"+ xhr.responseText);
                }
            });
        });
        $("#nightbox").change(function() {
            $.ajax({
                type     : "POST",
                cache    : false,
                url      :  '../nightmode.php',
                success : function(data){
                    if(data==1){
                        $("body").css("background-color","rgb(22,22,22)");
                    }else{
                        $("body").css("background-color","#f0f1f5");
                    }
                },
                error: function(xhr, status, error) {
                    alert("error"+ xhr.responseText);
                }
            });
        });
        $("#collapsebox").change(function() {
            $.ajax({
                type     : "POST",
                cache    : false,
                url      :  '../collapse.php',
                success : function(data){
                },
                error: function(xhr, status, error) {
                    alert("error"+ xhr.responseText);
                }
            });
        });
        $("#geoloc").change(function() {
            $.ajax({
                type     : "POST",
                cache    : false,
                url      :  '../nearby.php',
                success : function(data){
                    if(data==1){
                        $(".navbar-right>li:eq(3)").html("<a href='/$followed'>followed</a>");
                    }else{
                        $(".navbar-right>li:eq(3)").html("<a href='/$near'>near</a>");
                    }
                },
                error: function(xhr, status, error) {
                    alert("error"+ xhr.responseText);
                }
            });
        });
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <?
        if($login) echo '<script src="/js/notification.js"></script>';
    ?>
</body>
</html>
