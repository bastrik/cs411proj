<!DOCTYPE HTML>
    <?
    session_start();
    include_once "php/checklogin.php";
    $login = isset($_SESSION['user_id']);
    if($login){
        header("location:\$best");
    }
?>
<html>
<head>
    <title>Stacksity | About</title>
    <meta name="description" content="Stacksity About">
    <meta name="viewport" content="width=device-width, minimal-ui, initial-scale=1, maximum-scale=1, user-scalable=no"/>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" href="img/favicon.ico">
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
    <meta name="description" content="Stacksity is a social network, alternative Reddit, allowing users to submit and vote on content.">
    <meta name="keywords" content="Stacksity, stack, stacks, social network, vote, topstack, university, reddit alternative, reddit clone, reddit, stackcity, not stackcity, reddit sucks, ellen pao sucks, voat, voat co" />
    <meta name="author" content="Tyler Han"/>
    <meta name="distribution" content="global"/>
    <meta http-equiv="content-language" content="en-us"/>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/aboutstyle.css">
</head>
<body class="no-js">
    <div class="main">
        <header>
            <div class="wrap">
                <img src="img/iphone.png" height="532" width="252" alt="" class="header-img">
                <div class="header-wrapper">
                    <h1>Stacksity</h1>
                    <p>Share links, text, and photos with nearby and with the world. Discuss issues, read news, or just show your friends something funny. The latest in everything and anything.</p>
                    <p class="autor"><a href="#">Available on iOS and Android</a></p>
                    <div class="buttons-wrapper">
                        <a href="#discover" class="button">Download App</a>
                        <a href="/$best" class="button button-stripe">Go to Website</a>
                    </div>
                </div>
                <!-- /.header-wrapper -->
            </div>
            <!-- /.wrap -->
        </header>
        <div class="spanning">
            <div class="promo clearfix">
                <div class="wrap">
                    <div class="video-title">Stacksity in 60 seconds</div>
                    <div class="video-subtitle">We all know you're busy, but it's just that easy</div>
                    <div class="video-block">
                        <div class="videoWrapper">
                            <iframe  src="https://www.youtube.com/embed/qmGJIz5m5lU?rel=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe>
                        </div>
                    </div>
                    <div class="promo-wrapper clearfix">
                        <div class="promo-column">
                            <div class="icon glyphicon glyphicon-map-marker marginbottom"></div>
                            <h5>Places</h5>
                            <p>Find content close, near, and far from you - get the latest from your lecture hall, campus, or city. </p>
                        </div>
                        <div class="promo-column">
                            <div class="icon glyphicon glyphicon glyphicon-search marginbottom"></div>
                            <h5>Explore</h5>
                            <p>Each <i>stack</i> is a topic, a category, and a community - providing content and news updates. </p>
                        </div>
                        <div class="promo-column">
                            <div class="icon glyphicon glyphicon-user marginbottom"></div>
                            <h5>Outreach</h5>
                            <p>You are also a stack! If you want, gain followers and make your own community</p>
                        </div>
                        <div class="promo-column">
                            <div class="icon glyphicon glyphicon-globe marginbottom"></div>
                            <h5>Global</h5>
                            <p>Vote on posts from around the world. Stack up posts you like, Stack down ones you don’t.</p>
                        </div>
                    </div>
                </div>
                <!-- /.wrap -->
            </div>
            <!-- /.promo clearfix -->
            <div class="discover clearfix" id="discover">
                <div class="wrap">
                    <div class="discover-content clearfix">
                        <h2>Get Stacking</h2>
                        <div class="discover-button clearfix">
                            <a href="https://geo.itunes.apple.com/ca/app/stacksity/id1052618205?mt=8" class="button button-download">
                                <span class="button-download-title">Download for</span>
                                <span class="button-download-subtitle">Apple iOS</span>
                            </a>
                            <a href="https://play.google.com/store/apps/details?id=com.stack.stacksity" class="button button-download android">
                                <span class="button-download-title">Download for</span>
                                <span class="button-download-subtitle">Android</span>
                            </a>
                        </div>
                        <p>What are you waiting for? Get Stacksity quick and easy with one download. Go follow stacks about your interests and hobbies - from <i>$food</i> to <i>$cute</i>, from <i>$science</i> to <i>$news</i>.<br>
                        <!--<br>We believe in free speech and expression, so go wild and speak your mind :D <i>(We won't judge, but keep it legal)</i>-->
                            <br>Remain anonymous but still get recognition and followers, or go bold and speak your mind as yourself!
                        </p>

                    </div>
                    <div class="discover-img">
                        <img src="img/logo.jpg" style="width: 100%">
                    </div>
                </div>
                <!-- /.wrap -->
            </div>
            <!-- /.discover clearfix -->
            <div class="discover clearfix" id="feature">
                <div class="wrap">
                    <div class="video-title">PRESS</div>
                    <div class="row">
                        <div class="col-md-4">
                            <a href="https://www.reddit.com/r/RedditAlternatives/comments/3bzm5p/a_list_of_all_the_reddit_alternatives_that_i/" target="_blank"><img src="https://skipcdn.net/img/press/reddit.png" alt="reddit"></a>
                            <a href="http://androidworld.nl/apps/serieuze-en-onnozele-content-een-app/" target="_blank"><img src="http://static.tumblr.com/04e3ff5804cef6fd721c1f9a854b58e8/6bva2do/H0dmx6ros/tumblr_static_androidworld1.png" alt="reddit"></a>
                        </div>
                         <div class="col-md-4">
                             <a href="http://www.wired.co.uk/news/archive/2015-06/11/reddit-revolt" target="_blank"><img src="http://static.tumblr.com/f28d88f2904e06d33b08ae1ade2dd0e5/b9byeoh/cXQnk0rzn/tumblr_static_dkuj759j1vwo4owo8kscg4cok.png" alt="wired"></a>
                             <a href="http://www.idigitaltimes.com/best-reddit-alternatives-voatco-down-time-continues-after-new-comers-protesting-449338" target="_blank"><img src="http://stopitcyberbully.com/assets/img/news/idigital-times.png" alt="idigitaltimes"></a>
                             <a href="http://blog.campussociety.com/reddit-alternatives#sthash.VQK83vzn.dpbs" target="_blank"><img src="http://blog.campussociety.com/wp-content/uploads/2015/07/6DQTzU8jQ1ZcHzxVnuT_w0aalJca7sb3lSGTaGm-HXM-1024x532.png" alt="idigitaltimes"></a>
                         </div>
                         <div class="col-md-4">
                             <a href="http://www.dailydot.com/politics/reddit-alternatives-goodbye-cruel-world/" target="_blank"><img src="https://skipcdn.net/img/press/dailydot.png" alt="the daily dot"></a>
                             <a href="https://medium.com/@sobeyharker/52-alternatives-to-reddit-1a9dcf5e0658#.f5pupshig" target="_blank"><img src="https://cdn-images-1.medium.com/max/800/1*5ztbgEt4NqpVaxTc64C-XA.png" alt="medium"></a>
<!--                             <a href="https://www.facebook.com/stacksity/" target="_blank"><img src="http://career.uncc.edu/sites/career.uncc.edu/files/media/Facebooklogo.png" alt="facebook"></a>-->
                             <a href="https://twitter.com/hashtag/stacksity" target="_blank"><img src="http://www.southernfriedscience.com/wp-content/uploads/2011/12/logo_twitter_withbird_1000_allblue.png" alt="twitter"></a>

                         </div>
                    </div>
                </div>
                <!-- /.wrap -->
            </div>
            <!-- /.videos clearfix -->
            <div class="comments clearfix">
                <div class="wrap">
                    <div class="tab">
                        <div class="box visible">
                            <h4>More questions?</h4>
                            <p>If you have plenty more burning questions to ask, check out our <a href="/faq" style="color: #fff; text-decoration: underline">FAQ</a>.</p>
                        </div>
                        <div class="video-share-wrapper clearfix">
                            <ul class="social-list clearfix">
                                <li class="video-share-title">Find us over at:</li>
                                <li><a href="https://twitter.com/stacksity" class="social-twitter"><strong>Twitter</strong></a></li>
                                <li><a href="https://www.facebook.com/stacksity" class="social-facebook"><strong>Facebook</strong></a></li>
                                <li><a href="https://stacksity.com/$stacksity" class="social-stacksity"><strong>Stacksity</strong></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /.wrap -->
            </div>
            <!-- /.newsletter clearfix -->
        </div>
        <!-- /.spanning-columns -->
    </div>
    <!-- /.main -->
    <footer>
        <div class="wrap">
            <p>&copy; 2015 <strong>Stacksity</strong>, All Rights Reserved</p>
        </div>
        <!-- /.wrap -->
    </footer>
</body>
</html>
