<?php
session_start();
include_once "php/checklogin.php";
$login = isset($_SESSION['user_id']);
$postid = $_GET['id'];
$stack = false;
$stacks = false;
if(!isset($postid) || !is_numeric($postid)){
    header('location: ../php/postnotfound.php');
    exit();
}
include_once 'php/getpost.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>

    <title>Stacksity | <? echo $postname;?></title>

    <meta property="og:title" content="<? echo $postname;?>" />
    <meta property="og:site_name" content="Stacksity"/>
    <meta property="og:url" content="https://stacksity.com/p/<? echo $postid?>" />
    <meta property="og:type" content="website" />
    <meta property="og:image" content="<? echo $image;?>">
    <meta name="twitter:image" content="<? echo $image;?>">

    <meta name="viewport" content="width=device-width, minimal-ui, initial-scale=1, maximum-scale=1, user-scalable=no"/>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="apple-itunes-app" content="app-id=1052618205">
    <link rel="icon" href="/img/favicon.ico">
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
    <meta name="keywords" content="Stacksity, stack, stacks, social network, vote, topstack, university, reddit alternative, reddit clone, reddit, stackcity, not stackcity, reddit sucks, ellen pao sucks, voat" />
    <meta name="author" content="Tyler Han"/>
    <meta name="distribution" content="global"/>
    <meta http-equiv="content-language" content="en-us"/>

    <link rel="stylesheet" href="../css/reset.css">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">

    <link rel="stylesheet" href="../css/style.css">

    <?if(isset($_COOKIE["night"])&&$_COOKIE['night']>0){
        echo '<link rel="stylesheet" href="../css/nightmode.css">';
    }?>
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
</head>

<body>
<?
if($login) echo '<input id="login" type="hidden" value="1">';
else echo '<input id="login" type="hidden" value="0">'
?>
<input id="postid" type="hidden" value="<?
echo $postid;
?>"/>
<?if(isset($_GET["cid"])&&is_numeric($_GET["cid"])) echo '<input id="comid" type="hidden" value="'.$_GET["cid"].'"/>'?>
<!-- Fixed navbar -->
<? include_once 'php/header.php';?>
<div class="headergap"></div>

<div id="postcon" class="center" >
<?//if(!$login){ include_once 'php/shouldlogin.php';}
//  else echo ''?>
</div>
<div class="center back" onclick="window.top.close();"><div class="glyphicon glyphicon-remove"></div> Close Tab</div>
<style>
    @media (min-width: 768px){
        .item{
            padding: 20px;
        }
    }
</style>
<?if(!$login){
    echo '<style>
            .app-store{
                display: none;
            }
            @media (max-width: 979px) {
                .app-store{
                    display: block;
                    overflow: hidden;
                    width: 100%;
                    height: 62px;
                    margin-top: -10px;
                    padding: 0;
                }
                .button-download {
                    height: 62px;
                    float: left;
                    font: 500 11px/13px "Raleway", "Helvetica Neue", Helvetica, Arial, sans-serif;
                    width: 50%;
                    text-align: left;
                    position: relative;
                    -moz-box-sizing: border-box;
                    -webkit-box-sizing: border-box;
                    box-sizing: border-box;
                    background: #000;
                    color: #fff;
                    padding-left: 61px;
                }
                .button-download:hover{
                    text-decoration: none;
                    background-color: #333;
                    color: #fff;
                }
                .button-download-subtitle {
                    display: block;
                    font-size: 21px;
                    line-height: 23px;
                    text-align: left;
                }
                .button-download-title {
                    padding: 11px 0 1px;
                    display: block;
                    font-size: 11px;
                    line-height: 13px;
                    text-align: left;
                }
                .button-download:after {
                    content: "";
                    position: absolute;
                    left: 23px;
                    top: 14px;
                    width: 32px;
                    height: 32px;
                    background: url("/img/sprite.png") 0 0 no-repeat;
                    background-position: -100px 0;
                }
                .button-download.android:after {
                    background-position: -150px 0;
                }
                .button-download.android {
                    border-left: 1px solid #fff;
                }
            }
          </style>
         <div class="app-store center">
            <a href="https://geo.itunes.apple.com/ca/app/stacksity/id1052618205?mt=8" class="button button-download">
                <span class="button-download-title">Stacksity for</span>
                <span class="button-download-subtitle">iPhone</span>
            </a>
            <a href="https://play.google.com/store/apps/details?id=com.stack.stacksity" class="button button-download android">
                <span class="button-download-title">Stacksity for</span>
                <span class="button-download-subtitle">Android</span>
            </a>
        </div>';
}
?>
<div id="comments" class="center">
    <?if($login){ include_once 'php/commentform.php';}?>
    <div class="commentfeed">
    </div>
</div>
<div class="center back" onclick="window.top.close();"><div class="glyphicon glyphicon-remove"></div> Close Tab</div>
<div class="modal fade" id="delpost">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <p>Are you sure you want to delete this post?</p>
            </div>
            <div class="modal-footer">
                <a id="deletelink" class="btn btn-primary">Delete</a>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="commentdelete">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <p>Are you sure you want to delete this comment?</p>
            </div>
            <div class="modal-footer">
                <a id="deletecomment" class="btn btn-primary">Delete</a>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="repost">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <p>Are you sure you want to report this post? Only report posts that have not been properly labeled NSFW or are blatantly illegal. An abuse of the report function will have severe automatic consequences.</p>
            </div>
            <div class="modal-footer">
                <a id="reportlink" class="btn btn-primary">Report</a>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<script src="/js/output.js"></script>
<script src="/js/autogrow.js"></script>
<?
echo "<script> var postdata = ".$postdata.";</script>";
?>
<script src="/js/post.js"></script>
<?
if($login) {
    echo '<script src="/js/vote.js"></script>';
    echo '<script src="/js/postvote.js"></script>';
    echo '<script src="/js/notification.js"></script>';
};
?>

</body>
</html>