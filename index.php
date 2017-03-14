<?
session_start();
include_once "php/checklogin.php";
if(isset($_SESSION['user_id'])){
    header("location:\$best");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Stacksity | Welcome</title>
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
        <meta name="keywords" content="Stacksity, Stackcity, Stack city, stack, stacks, social network, vote, topstack, university" />
<!--        <meta name="author" content="Tyler Han"/>-->
        <meta name="distribution" content="global"/>
        <meta http-equiv="content-language" content="en-us"/>




        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">

        <link rel="stylesheet" href="css/style.css">

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <script src='https://www.google.com/recaptcha/api.js'></script>
        <script>
        function onloadCallback() {
        /* Place your recaptcha rendering code here */
            grecaptcha.render('cap1', {
                "data-size" : "compact"
            });
        }
        </script>
    </head>

    <body id="loginbody">

        <? $page = 1;
        include_once "pageheader.php" ?>
<!--        <canvas width="1" height="1" id="raincontainer" style="position:absolute"></canvas>-->
        <div class="site-wrapper-wrapper">
        <div class="site-wrapper">
            <div class="site-wrapper-inner">
                <div class="container" id="logincon">
                    <div class="row">
                        <div class="col-md-8 col-sm-7">
                            <div class="intro">
                                <h1>Welcome to STACK$ITY</h1>
                                <?
                                    if(isset($_GET['err'])){
                                        echo '<div id="log-alert" class="alert alert-danger alert-dismissible" role="alert" maxlength="48" style="display: block; max-width: 450px">
                                                <button type="button" class="close" onclick="slideout(\'log-alert\');"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                <span class="err" "><b>';
                                        if($_GET['err']==2){
                                            echo "You need an account to view content.<br> Sign up! Its fast and its free. Promise.";
                                        }
                                        echo '</b></span>
                                        </div>';
                                    }
                                ?>
                                <p>Share links, text, and images with your friends and with the world. Discuss issues, read news, or just show your friends something funny. Vote your favorites to the top of the stack!</p>
                                <a href="$best" style="color: #fff"><h2>Explore Stacks</h2></a>
                                <ul class="frontstack" style="padding: 0px;">
                                    <a href="$near"><li style=" background-image:url(/img/earth.jpg)">$near</li></a>
                                    <a href="$cute"><li style="background-image: url(http://i.imgur.com/UGQaZLT.jpg)">$cute</li></a>
                                    <a href="$discuss"><li style=" background-image:url(http://i.imgur.com/lF8HyKW.jpg)">$discuss</li></a>
                                    <a href="$lol"><li style=" background-image:url(http://i.imgur.com/o9Q3odr.jpg)">$lol</li></a>
                                    <a href="$fitness"><li style=" background-image:url(http://i.imgur.com/lskVSUx.jpg)">$fitness</li></a>
                                    <a href="$food"><li style=" background-image:url(http://i.imgur.com/m2T28qJ.jpg)">$food</li></a>
                                    <a href="$foundout"><li style=" background-image:url(http://i.imgur.com/vjwlZ2z.jpg)">$foundout</li></a>
                                    <a href="$gaming"><li style=" background-image:url(http://i.imgur.com/Dzjl72V.jpg)">$gaming</li></a>
                                    <a href="$interesting"><li style=" background-image:url(http://i.imgur.com/d7K05QO.jpg)">$interesting</li></a>
                                    <a href="$music"><li style=" background-image:url(http://i.imgur.com/HCd3FqL.jpg)">$music</li></a>
                                    <a href="$news"><li style=" background-image:url(http://i.imgur.com/FRkE5qO.jpg)">$news</li></a>
                                    <a href="$science"><li style=" background-image:url(http://i.imgur.com/N3CHB6k.jpg)">$science</li></a>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-5">
                            <form class="signinform margintop" id="login">
                                <h2 class="form-signin-heading">Welcome back! Login</h2>
                                <label for="inputEm" class="sr-only">Username/Email</label>
                                <input name="inputEm" type="text" id="inputEm" class="form-control" placeholder="Email/Username" required autofocus>
                                <label for="inputPass" class="sr-only">Password</label>
                                <input name="inputPass" type="password" id="inputPass" class="form-control" placeholder="Password" required>
                                <div id="login-alert" class="alert alert-danger alert-dismissible" role="alert" maxlength="48">
                                    <button type="button" class="close" onclick="slideout('login-alert');"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                    <span id="ref">The username/password doesn't seem to work :(</span>
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
                            <form class="signinform margintop marginbottom" id="account" role="form" data-toggle="validator">
                                <h2 class="form-signin-heading" id="form2head">New to Stacksity? Sign up</h2>
                                <div id="inforeg" style="display: none">
                                    <p>Alright, you're in. Now <b>Login above</b>, and welcome to Stacksity :D</p>
                                </div>
                                <div id="info">
                                    <label for="inputEmail" class="sr-only">Email address</label>
                                    <input name="email" type="email" id="inputEmail" class="form-control" placeholder="Email address" required maxlength="254">
                                    <div id="email-alert" class="alert alert-danger alert-dismissible" role="alert">
                                        <button type="button" class="close" onclick="slideout('email-alert');"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                        <span>Sorry, seems like this email is taken</span>
                                    </div>
                                    <label for="inputName" class="sr-only">Stacksity Username</label>
                                    <input name="username" type="text" id="inputUsername" class="form-control margintop" placeholder="Stacksity Username" required style="margin-top: 2px" maxlength="32">
                                    <div id="user-alert" class="alert alert-danger alert-dismissible" role="alert" maxlength="48">
                                        <button type="button" class="close" onclick="slideout('user-alert');"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                        <span>Sorry, seems this username is taken</span>
                                    </div>
                                    <label for="inputPassword" class="sr-only">Password</label>
                                    <input name="password" type="password" id="inputPassword" class="form-control" placeholder="Password" required maxlength="32">
                                    <div id="pass-alert" class="alert alert-danger alert-dismissible" role="alert">
                                        <button type="button" class="close" onclick="slideout('pass-alert');"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                        <span id="reference">Pass needs to be longer than 6 characters</span>
                                    </div>
                                    <div class="g-recaptcha" data-sitekey="6Ldf3BgUAAAAAOJcgl_ajXlrh-Fd8ePu_9yeNlk1"></div>
                                    <button class="btn btn-lg btn-primary btn-block margintop" type="submit">Sign Up</button>
                                    <p class="small">By signing up, you agree to the <a href="privacy.php">Privacy Policy</a></p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!--<div class="cover-container">
                    <div class="inner cover">
                        <h1 class="cover-heading">Cover your page.</h1>
                        <p class="lead">Cover is a one-page template for building simple and beautiful home pages. Download, edit the text, and add your own fullscreen background photo to make it your own.</p>
                        <p class="lead">
                            <a href="#" class="btn btn-lg btn-default">Learn more</a>
                        </p>
                    </div>
                </div>-->
            </div>
        </div>
        </div>
<!--        <script type="text/javascript" src="js/rain.js"></script>-->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
        <script src="js/signup.js"></script>
    </body>
</html>
