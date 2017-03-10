<?php
session_start();
include_once "php/checklogin.php";
$login = isset($_SESSION['user_id']);
$stacks = true;
$stack = false;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Stacksity | Stacks</title>
    <meta name="viewport" content="width=device-width, minimal-ui, initial-scale=1, maximum-scale=1, user-scalable=no"/>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" href="/img/favicon.ico">
    <meta property="og:image" content="/img/ms-icon-310x310.png">
    <meta name="twitter:image" content="/img/ms-icon-310x310.png">
    <meta itemprop="image" content="/img/ms-icon-310x310.png">
    <link rel="shortcut icon" href="/img/favicon.ico">
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
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">

    <link rel="stylesheet" type="text/css" href="https://code.jquery.com/ui/1.10.0/themes/ui-lightness/jquery-ui.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/auto.css">
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
<?include_once 'php/header.php'?>
<div class="headergap"></div>
<div class="center stacks">
    <div class="row">
            <div class="col-sm-12">
                <form class="searchfor">
                    <h1>Search for Users/Stacks</h1>
                    <p>Non-User stacks begin with a <b>$</b> | <a href="https://stacksity.com/faq.html#basics" target="_blank">Make any stack just by visiting it, they all exist</a></p>
                    <input name="stacks" type="text" class="form-control" id="autocomplete" placeholder="Search for...">
                </form>
            </div>
            <div class="col-sm-4">
                <div class="stacklist">
                    <h5>Followed Stacks</h5>
                    <div class="stackl" id="fs">
                        <? if(!$login) echo'Login to see Followed Users';?>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="stacklist">
                    <h5>Followed Users</h5>
                    <div class="stackl" id="fu">
                    <? if(!$login) echo'Login to see Followed Users';?>
                    </div>
                </div>
                <div class="stacklist">
                    <h5>Default Stacks</h5>
                    <div class="stackl listlink" id="es">
                        <a href="$art">$art</a>
                        <a href="$cute">$cute</a>
                        <a href="$discuss">$discuss</a>
                        <a href="$fitness">$fitness</a>
                        <a href="$food">$food</a>
                        <a href="$foundout">$foundout</a>
                        <a href="$gaming">$gaming</a>
                        <a href="$interesting">$interesting</a>
                        <a href="$lol">$lol</a>
                        <a href="$movies">$movies</a>
                        <a href="$music">$music</a>
                        <a href="$news">$news</a>
                        <a href="$photography">$photography</a>
                        <a href="$questions">$questions</a>
                        <a href="$science">$science</a>
                        <a href="$writing">$writing</a>
                        <a href="$videos">$videos</a>
                    </div>
                </div>
                <div class="stacklist">
                    <h5>University Stacks</h5>
                    <div class="stackl listlink" id="es">
                        <a href="$university">$university</a>
                        <a href="$ubc">UBC ($ubc)</a>
                        <a href="$uchicago">UChicago ($uchicago)</a>
                        <a href="$uoft">UofT ($uoft)</a>
                    </div>
                </div>

<!--                <div class="stacklist">-->
<!--                    <h5>CAIMUN 2015</h5>-->
<!--                    <div class="stackl listlink" id="es">-->
<!--                        <a href="$caimun">CAIMUN</a>-->
<!--                        <a href="$caimunnews">News</a>-->
<!--                        <a href="$caimunal">Arab League</a>-->
<!--                        <a href="$caimunapec">APEC</a>-->
<!--                        <a href="$caimuncov">CoV</a>-->
<!--                        <a href="$caimuncstd">CSTD</a>-->
<!--                        <a href="$caimundisec">DISEC</a>-->
<!--                        <a href="$caimunexxon">ExxonMobil</a>-->
<!--                        <a href="$caimunhwc">HWC</a>-->
<!--                        <a href="$caimuniaea">IAEA</a>-->
<!--                        <a href="$caimunspecpol">SPECPOL</a>-->
<!--                        <a href="$caimunundp">UNDP</a>-->
<!--                        <a href="$caimununsc">UNSC</a>-->
<!--                        <a href="$caimunuss">USS</a>-->
<!--                        <a href="$caimunwb">World Bank</a>-->
<!--                    </div>-->
<!--                </div>-->
            </div>

        <div class="col-sm-4">
            <div class="stacklist">
                <h5>Collections</h5>
                <div class="stackl listlink" id="es">
                    <a href="/$everything">$everything</a>
                    <a href="/$recent">$recent</a>
                </div>
            </div>
            <div class="stacklist">
                <h5>Featured</h5>
                <div class="stackl listlink" id="es">
                    <a href="/$writing">$writing</a>
                    <a href="/$pokemon">$pokemon</a>
                </div>
            </div>
            <div class="stacklist">
                <h5>Games</h5>
                <div class="stackl listlink" >
                    <a href="$gaming">$gaming</a>
                    <a href="$ssb">$ssb</a>
                    <a href="$rpg">$rpg</a>
                    <a href="$leagueoflegends">$leagueoflegends</a>
                    <a href="$hearthstone">$hearthstone</a>
                    <a href="$counterstrike">$counterstrike</a>
                    <a href="$gamesonsale">$gamesonsale</a>
                </div>
            </div>
            <div class="stacklist">
                <h5>Video</h5>
                <div class="stackl listlink" >
                    <a href="$movies">$movies</a>
                    <a href="$tv">$tv</a>
                    <a href="$videos">$videos</a>
                    <a href="$documentaries">$documentaries</a>
                    <a href="$musicvideos">$musicvideos</a>
                    <a href="$anime">$anime</a>
                </div>
            </div>
            <div class="stacklist">
                <h5>Nutrition</h5>
                <div class="stackl listlink" >
                    <a href="$food">$food</a>
                    <a href="$recipes">$recipes</a>
                    <a href="$foodblogs">$foodblogs</a>
                    <a href="$fitness">$fitness</a>
                </div>
            </div>
            <div class="stacklist">
                <h5>Cities</h5>
                <div class="stackl listlink" >
                    <a href="$vancouver">$vancouver</a>
                    <a href="$chicago">$chicago</a>
                    <a href="$toronto">$toronto</a>
                    <a href="$seattle">$seattle</a>
                    <a href="$montreal">$montreal</a>
                    <a href="$winnipeg">$winnipeg</a>
                </div>
            </div>
            <div class="stacklist">
                <h5>Music</h5>
                <div class="stackl listlink" >
                    <a href="$music">$music</a>
                    <a href="$musicproduction">$musicproduction</a>
                    <a href="$electronicmusic">$electronicmusic</a>
                    <a href="$hiphop">$hiphop</a>
                    <a href="$metal">$metal</a>
                    <a href="$listentothis">$listentothis</a>
                    <a href="$jazz">$jazz</a>
                    <a href="$beats">$beats</a>
                </div>
            </div>
            <div class="stacklist">
                <h5>Tech</h5>
                <div class="stackl listlink" >
                    <a href="$technews">$technews</a>
                    <a href="$techtoys">$techtoys</a>
                    <a href="$programming">$programming</a>
                    <a href="$buildapc">$buildapc</a>
                    <a href="$apple">$apple</a>
                    <a href="$android">$android</a>
                    <a href="$microsoft">$microsoft</a>
                </div>
            </div>
            <div class="stacklist">
                <h5>Visual</h5>
                <div class="stackl listlink" >
                    <a href="$art">$art</a>
                    <a href="$design">$design</a>
                    <a href="$comics">$comics</a>
                    <a href="$critiquemyart">$critiquemyart</a>
                    <a href="$graffiti">$graffiti</a>
                    <a href="$typography">$typography</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/ui/1.10.0/jquery-ui.min.js" type="text/javascript"></script>
<script type="text/javascript">

    $(function() {
        $("#autocomplete").autocomplete({
            source: "../php/search.php",
            minLength: 1,
            focus: function(event, ui) {
                // prevent autocomplete from updating the textbox
                event.preventDefault();
                // manually update the textbox
                $(this).val(ui.item.label);
            },
            select: function(event, ui) {
                var url = ui.item.id;
                    location.href = '/stack.php?id=' + url;
            }
        });

    });
    $(".searchfor").on('submit', function(e){
        e.preventDefault();
        var id = $(this).children('#autocomplete').val();
        location.href = '/stack.php?id=' + id;
    });
</script>
<?
if($login) echo '<script src="/js/stacks.js"></script>
<script src="/js/notification.js"></script>';
?>

</body>
</html>