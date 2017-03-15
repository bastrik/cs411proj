<?php
//hi
session_start();
include_once "php/checklogin.php";
$login = isset($_SESSION['user_id']);
if(!isset($_GET['id'])){
    $stack = 0;
}else{
    $stack = strtolower($_GET['id']);
    if($stack==-2&&!$login){
        header("location:/$best");
    }
//    }else if($stack==-4){
//        echo '<script>
//                var delete_cookie = function(name) {
//                    document.cookie = name + "=;expires=Thu, 01 Jan 1970 00:00:01 GMT;";
//                };
//                function getLocation() {
//                    if (navigator.geolocation) {
//                        navigator.geolocation.getCurrentPosition(showPosition);
//                    } else {
//                        delete_cookie("nearbyoff")
//                        alert("Geolocation is not supported by this browser.");
//                    }
//                }
//                function showPosition(position) {
//                    alert("Latitude: " + position.coords.latitude +
//                    "<br>Longitude: " + position.coords.longitude);
//                }
//                getLocation();
//                </script>';
//    }
}
$stacks = false;
include_once "php/stackname.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>eBase XCHG | <?
        echo $stackname;
    ?></title>
    <meta name="description" content="<? echo $stackname." | ".$stack_desc;?>">
    <meta name="viewport" content="width=device-width, minimal-ui, initial-scale=1, maximum-scale=1, user-scalable=no"/>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="apple-itunes-app" content="app-id=1052618205">
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
    <meta name="description" content="Buy, sell, and exchange with people in your area! There's a place for everything. Don't let them sit collecting dust while taking up space at home!">
    <meta name="keywords" content="eBase, XCHG, ride share, furniture, electronics, tickets, services, books" />
    <meta name="author" content=""/>
    <meta name="distribution" content="global"/>
    <meta http-equiv="content-language" content="en-us"/>

    <link rel="stylesheet" href="../css/reset.css">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">

    <link rel="stylesheet" href="../css/style.css">

    <?if(isset($_COOKIE["night"])&&$_COOKIE['night']>0){
        echo '<link rel="stylesheet" href="../css/nightmode.css">';
    }
    if(isset($theme)){
        echo '<link rel="stylesheet" href="../css/custom/'.$theme.'.css">';
    }
    if(isset($_COOKIE["collapse"])){
        echo '<style>.collapsecon{
                display: none;
              }</style>';
    }?>
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="/fancybox/jquery.fancybox.css" type="text/css" media="screen" />
    <script type="text/javascript" src="/fancybox/jquery.fancybox.js"></script>
</head>

<body>
<?
if($nsfw&&(!$login||!isset($_SESSION["nsfw"])||$_SESSION["nsfw"]==0)){
    echo '<div class="modal" id="nsfwmodal" tabindex="-1" role="dialog" aria-hidden="false" xmlns="http://www.w3.org/1999/html">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
                <h4 class="modal-title" id="myModalLabel">This is a Not Safe For Work Stack.</h4>
              </div>
              <div class="modal-body">
                Are you over 18?
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Yes</button>
                <a href="/$best" class="btn btn-primary">No</a>
              </div>
            </div>
          </div>
        </div>
        <script type="text/javascript">
            $("#nsfwmodal").modal({
              keyboard: false,
              backdrop: "static"
            });
            $("#nsfwmodal").modal("show");
        </script>';
}
?>
<input id="stack" type="hidden" value="<?
    echo $stack;
?>"/>
<input id="stackname" type="hidden" value="<?
    echo $stackname;
?>"/>
<input id="isuser" type="hidden" value="<?
echo $is_user;
?>"/>
<!-- Fixed navbar -->
<? include_once 'php/header.php'?>
<div class = "banner <?
    if($stack==0){
        echo "topbanner";
    }else if($stack<0||$stack==4917){
        echo "allbanner";
    }else if(isset($banner)){
        echo '" style = " background-image:url(\''.$banner.'\')';
    }else if($nsfw){
        echo "nsfwbanner";
    }else if($stackname[0]!='$'){
        echo "userbanner";
    }
?>">
    <div class="banner-mid" <?if(isset($banner)) echo "style='background-color: rgba(0,0,0,0.4);'"; ?>>
    <div class="container banner-inner">
        <div class="bannertext"><h1 style="margin-bottom: 0"><?echo $stackname?></h1>
        <?
            if($stack>0&&$stack!=4917){
                if($stack==0&&!$login){
                    echo '<ul class="frontstack">
                                        <a href="$cute"><li style="background-image: url(http://i.imgur.com/4RgwHYp.jpg)">$service</li></a>
                                        <a href="$discuss"><li style=" background-image:url(http://i.imgur.com/o8c067T.jpg)">$electronics</li></a>
                                        <a href="$lol"><li style=" background-image:url(http://i.imgur.com/gbtSyQB.jpg)">$furniture</li></a>
                                        <a href="$fitness"><li style=" background-image:url(http://i.imgur.com/vjwlZ2z.jpg)">$books</li></a>
                                        <a href="$food"><li style=" background-image:url(http://i.imgur.com/pGY7f3A.jpg)">$RideShare</li></a>
                                        <a href="$foundout"><li style=" background-image:url(http://i.imgur.com/UGQaZLT.jpg)">$others</li></a>
                                    </ul>
                                    <div style="padding: 10px 0 20px 0;">
                                    <h1>> <a href="/home">Get Started with STACKSITY</a></h1>
                                    <span style="font-size: 18px">Buy, sell, and exchange with people in your area! There\'\s a place for everything. Don\'t\ let them sit collecting dust while taking up space at home!</span></div>';
                }else{
                    echo "<p id='bio' style='font-size: 1.0em;'>".$stack_desc."</p>";
                    if($stack==$_SESSION['stack_id']){
                        echo '<div id="bioedit">Edit Biography</div></br>';
                    }
                    echo '';
                }
                echo "<p><span id='followers'>".$followers."</span> Followers</p>";
            }
            echo "</div>";
//            if($login){
//                if($stack>0&&$stack!=4917&&($stack!=$_SESSION['stack_id'])){
//                    echo'<button class="follow';
//                    if($follow){
//                        echo ' followed" value="1">Followed</button>';
//                    }else {
//                        echo '" value="0">Follow</button>';
//                    }
//                }
//            }
        ?>
    </div>
    </div>
</div>
<div class="container" style="padding: 0;">
<div class="row">
    <div class="col-md-8" style="padding: 0px">
    <?
        if($stack==4917){
            if($login) include_once "php/postform.php";
            echo '<div class="center" style="padding-bottom: 6px; padding-top: 0px;">
                        <div class="btn-group btn-group-justified" role="group" aria-label="...">
                          <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default dist-btn" onclick="setDist(0.1, this)">Close</button>
                          </div>
                          <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default dist-btn" onclick="setDist(5.0, this)" disabled>Near</button>
                          </div>
                          <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default dist-btn" onclick="setDist(50.0, this)">Far</button>
                          </div>
                        </div>
                    </div>';
        }else{
            if($login){
                if($stack>0){
                    include_once "php/postform.php";
                }
                else{
                    echo "<div style='margin-top: 10px'></div>";
                }
            }
            else include_once 'php/shouldlogin.php';
            if($stack>0){
                if($is_user){
                    echo '<div class="center" style="padding: 0 0 6px 0">
                        <div class="btn-group btn-group-justified" role="group" aria-label="...">
                          <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default dist-btn" onclick="stat = 0; setDist(0, this)"" disabled>All</button>
                          </div>
                          <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default dist-btn" onclick="stat = 1; setDist(0, this)">Self</button>
                          </div>
                          <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default dist-btn" onclick="stat = 2; setDist(0, this)">Stacks</button>
                          </div>
                        </div>
                    </div>';
                }else {
                    echo '<div class="center" style="padding: 0 0 6px 0">
                        <div class="btn-group btn-group-justified" role="group" aria-label="...">
                          <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default dist-btn" onclick="stat = 0; setDist(0, this)"" disabled>Best</button>
                          </div>
                          <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default dist-btn" onclick="stat = 1; setDist(0, this)">New</button>
                          </div>
                          <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default dist-btn" onclick="stat = 2; setDist(0, this)">Top</button>
                          </div>
                        </div>
                    </div>';
                }
            }
        }
    ?>
        <div class="center" id="feed">
        </div>
        <div class="scroll center postloadbanner">
            <p>Loading Posts</p> <div class="loader" style="top: -35px">Loading...</div>
        </div>
    </div>
    <div class="col-md-4" style="padding: 0px">
        <div class="sidebar">
            <div id="fluidside">
                <? if(!$login){
                    echo '
<script src="https://www.google.com/recaptcha/api.js"></script>
        <script>
        function onloadCallback() {
            /* Place your recaptcha rendering code here */
            grecaptcha.render("cap1", {
                "data-size" : "compact"
            });
        }
        </script>
                <form class="signinform" id="login" style="margin-top: 10px">
                    <h2 class="form-signin-heading">Welcome back! Login</h2>
                    <label for="inputEm" class="sr-only">Username/Email</label>
                    <input name="inputEm" type="text" id="inputEm" class="form-control" placeholder="Email/Username" required autofocus>
                    <label for="inputPass" class="sr-only">Password</label>
                    <input name="inputPass" type="password" id="inputPass" class="form-control" placeholder="Password" required>
                    <div id="login-alert" class="alert alert-danger alert-dismissible" role="alert" maxlength="48">
                        <button type="button" class="close" onclick="slideout(\'login-alert\');"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <span id="ref">The username/password doesn\'t seem to work :(</span>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="checked" value="remember-me"> Remember me
                        </label>
                    </div>
                    <button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>
                    <a class="small" href="forgot_password.php">Forgot your password or username?</a>
                </form>
                <div class="signinform margintop" id="signin" style="display: none">
                    <button class="btn btn-lg btn-primary btn-block" onclick="signin()">Or sign in here</button>
                </div>
                <form class="signinform margintop marginbottom" id="account" role="form" onclick="slick()" data-toggle="validator">
                    <h2 class="form-signin-heading" id="form2head">New to Stacksity? Sign up</h2>
                    <div id="inforeg" style="display: none">
                        <p>Alright, you\'re in. Now <b>Login above</b>, and welcome to Stacksity :D</p>
                    </div>
                    <div id="info">
                        <label for="inputEmail" class="sr-only">Email address</label>
                        <input name="email" type="email" id="inputEmail" class="form-control" placeholder="Email address" required maxlength="254">
                        <div id="email-alert" class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" onclick="slideout(\'email-alert\');"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <span>Sorry, seems like this email is taken</span>
                        </div>
                        <label for="inputName" class="sr-only">Stacksity Username</label>
                        <input name="username" type="text" id="inputUsername" class="form-control margintop" placeholder="Stacksity Username" required style="margin-top: 2px" maxlength="32">
                        <div id="user-alert" class="alert alert-danger alert-dismissible" role="alert" maxlength="48">
                            <button type="button" class="close" onclick="slideout(\'user-alert\');"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <span>Sorry, seems this username is taken</span>
                        </div>
                        <label for="inputPassword" class="sr-only">Password</label>
                        <input name="password" type="password" id="inputPassword" class="form-control" placeholder="Password" required maxlength="32">
                        <div id="pass-alert" class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" onclick="slideout(\'pass-alert\');"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <span id="reference">Pass needs to be longer than 6 characters</span>
                        </div>
                        <div id="cap1" class="g-recaptcha margintop" data-sitekey="6LfZ5QMTAAAAADr8zlP-Aclz_ISiAXk7g6VBTYtR"></div>
                        <button class="btn btn-lg btn-primary btn-block margintop" type="submit">Sign Up</button>
                        <p class="small">By signing up, you agree to the <a href="privacy.php">Privacy Policy</a></p>
                    </div>
                    <script src="js/signup.js"></script>
                </form>';}

                ?>
                <h2>Explore Stacks</h2>
                <ul class="frontstack wide" style="padding: 0px;">
<!--                    <a href="$near"><li style=" background-image:url(/img/earth.jpg)">$near</li></a>-->
                    <a href="$cute"><li style="background-image: url(http://i.imgur.com/4RgwHYp.jpg)">$service</li></a>
                    <a href="$discuss"><li style=" background-image:url(http://i.imgur.com/o8c067T.jpg)">$electronics</li></a>
                    <a href="$lol"><li style=" background-image:url(http://i.imgur.com/gbtSyQB.jpg)">$furniture</li></a>
                    <a href="$fitness"><li style=" background-image:url(http://i.imgur.com/vjwlZ2z.jpg)">$books</li></a>
                    <a href="$food"><li style=" background-image:url(http://i.imgur.com/pGY7f3A.jpg)">$RideShare</li></a>
                    <a href="$foundout"><li style=" background-image:url(http://i.imgur.com/UGQaZLT.jpg)">$others</li></a>
                </ul>
            </div>
            <div id="sticky">
                <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                <!-- Stacksity Feed -->
                <ins class="adsbygoogle"
                     style="display:block"
                     data-ad-client="ca-pub-4753714915896025"
                     data-ad-slot="3281534396"
                     data-ad-format="auto"></ins>
                <script>
                    (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
                <h2>Find Stacksity</h2>
                <div class="social-icons">
                    <li class="facebook">
                        <a href="https://www.facebook.com/" target="_blank">Facebook</a>
                    </li>
                    <li class="youtube">
                        <a href="https://www.youtube.com/">YouTube</a>
                    </li>
                    <li class="twitter">
                        <a href="https://twitter.com/">Twitter</a>
                    </li>
                </div>
                <div>
                    <a href="contact.php">Advertise</a> | <a href="contact.php">Contacts</a> | <a href="privacy.php">Privacy</a> | <a href="faq.html">FAQ</a> | <a href="contact.php">Jobs</a>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
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
<div class="modal fade" id="editbiography">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editbio">
                <div class="modal-body">
                    <p style="margin-bottom: 10px">Edit Biography</p>
                    <textarea style="width: 100%; resize: vertical" id="biocontent"><?echo $stack_desc?></textarea>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="repost">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <p>Are you sure you want to report this post? Only report posts that have not been properly labeled NSFW or are blatantly illegal, an abuse of the report function will have automatic severe consequences</p>
            </div>
            <div class="modal-footer">
                <a id="reportlink" class="btn btn-primary">Report</a>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<script src="/js/autogrow.js"></script>
<script src="/js/output.js"></script>
<script src="/js/main.js"></script>
<?
if($login) echo '<script src="/js/vote.js"></script>
<script src="/js/notification.js"></script>';
?>
</body>
</html>