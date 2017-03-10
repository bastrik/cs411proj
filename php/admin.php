<?php
/**
 * Created by PhpStorm.
 * User: killswitch
 * Date: 4/14/2015
 * Time: 5:41 PM
 */
 require_once("head.php");
session_start();
include_once "checklogin.php";
$login = isset($_SESSION['user_id'])&&isset($_SESSION['admin'])&&$_SESSION['admin']==1;
if(!$login){
    header("location:/\$topstack");
    die();
}
$stacks = false;
$stack = false;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Stacksity | Admin</title>
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

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">

    <link rel="stylesheet" href="/css/style.css">
    <script src="/js/switchery.js"></script>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
<!-- Fixed navbar -->
<? include_once 'header.php'?>
<? if($_SESSION["stack_id"]==26){
    //header("location:http://www.reddit.com/r/spacedicks");
    echo'<audio autoplay>
          <source src="https://stacksity.com/img/paris.mp3" type="audio/mpeg" style="display: none">
        </audio>';
}?>
<div class = "banner topbanner">
    <div class="center banner-inner">
        <div class="bannertext banner-mid">
            <h1>ARE YOU AN ADMIN OR SOMETHING</h1>
        </div>
    </div>
</div>
<div class="center margintop">
    <div class="opline">
        <form id="bannertog">
            <h1>What are you expecting? Formatting? lol. change banner here</h1>
            <input name="stackid" type="text" placeholder="stackid"/>
            <textarea name="banner" type="text" placeholder="banner img link"></textarea>
            <button type="submit">submit</button>
        </form>
    </div>
    <div class="opline">
        <form id="nsfwtog">
            <h1>Toggle NSFW</h1>
            <input name="stackid" type="text" placeholder="stackid"/>
            <button type="submit">submit</button>
        </form>
    </div>
    <div class="opline">
        <form id="desctog">
            <h1>Edit Description</h1>
            <input name="stackid" type="text" placeholder="stackid"/>
            <textarea name="desc" type="text" placeholder="description here"></textarea>
            <button type="submit">submit</button>
        </form>
    </div>
    <div class="opline">
        <form id="flairtog">
            <h1>Edit Flair (only do this if you know HTML)</h1>
            <input name="stackid" type="text" placeholder="stackid"/>
            <textarea name="flair" type="text" placeholder="flair html here"></textarea>
            <button type="submit">submit</button>
        </form>
    </div>
    <div class="opline">
        <h1>Reports (when you dismiss it goes away forever)</h1>
        <table class="table table-striped" id="report">
            <tr>
                <th>Post Number</th>
                <th># of reports</th>
                <th>dismiss</th>
            </tr>
        </table>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script>
    $("#bannertog").on('submit', function(e){
        e.preventDefault();
        $.ajax({
            type     : "POST",
            cache    : false,
            url      : 'admin/banner.php',
            data     : $(this).serialize(),
            success  : function(data) {
                if(data==1){
                    alert("something went wrong");
                }else{
                    document.location.href = data;
                }
            },
            error: function(xhr, status, error) {
                alert("error"+ xhr.responseText);
            }
        });
    });
    $("#nsfwtog").on('submit', function(e){
        e.preventDefault();
        $.ajax({
            type     : "POST",
            cache    : false,
            url      : 'admin/nsfw.php',
            data     : $(this).serialize(),
            success  : function(data) {
                if(data==1){
                    alert("something went wrong");
                }else{
                    document.location.href = data;
                }
            },
            error: function(xhr, status, error) {
                alert("error"+ xhr.responseText);
            }
        });
    });
    $("#desctog").on('submit', function(e){
        e.preventDefault();
        $.ajax({
            type     : "POST",
            cache    : false,
            url      : 'admin/desc.php',
            data     : $(this).serialize(),
            success  : function(data) {
                if(data==1){
                    alert("something went wrong");
                }else{
                    document.location.href = data;
                }
            },
            error: function(xhr, status, error) {
                alert("error"+ xhr.responseText);
            }
        });
    });
    $("#flairtog").on('submit', function(e){
        e.preventDefault();
        $.ajax({
            type     : "POST",
            cache    : false,
            url      : 'admin/flair.php',
            data     : $(this).serialize(),
            success  : function(data) {
                if(data==1){
                    alert("something went wrong");
                }else{
                    document.location.href = data;
                }
            },
            error: function(xhr, status, error) {
                alert("error"+ xhr.responseText);
            }
        });
    });
    $.getJSON('admin/reports.php', function(data) {
        $.each(data, function(index, element) {
            $('#report').append("<tr id='"+element.reportlog_id+"'><td><a href='https://stacksity.com/p/"+
            element.post_id+"'>"+element.post_id+"</td><td>"+element.reports+"</td><td><a class='dis' data-id='"+element.reportlog_id+"'>dismiss</a></td></tr>");
        });
    });
    $(document).on('click','.dis',function(e){
        e.preventDefault();
        var id = $(this).data("id");
        $.ajax({
            type     : "GET",
            cache    : false,
            url      : 'admin/dismissreport.php',
            data     : {id: id},
            success  : function(data) {
                if(data==1){
                    alert("something went wrong");
                }else{
                    $("#"+id).fadeOut();
                }
            },
            error: function(xhr, status, error) {
                alert("error"+ xhr.responseText);
            }
        });
    });
</script>
<?
if($login) echo '<script src="/js/notification.js"></script>';
?>
</body>
</html>
