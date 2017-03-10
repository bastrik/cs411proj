<?php header("access-control-allow-origin: *"); ?>
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/$best">STACKSITY</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse login">
            <ul class="nav navbar-nav navbar-right">
                <? if($login){
                        echo '<li class="profile"><a href="/u/'.$_SESSION['stack_id'].'" id="selfid">'.$_SESSION['username'].'</a></li>';
                    }else {
                        echo '<li class="profile signup"><a href="../home" id="selfid">Login/Sign Up</a></li>';
                    }?>

                <?
                    if($login){
                        echo '
                            <li class="dropdown" id="note-drop">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                <id class="counter" style="display: none"></id>
                                <span id="messages" class="glyphicon glyphicon-bell" aria-hidden="true"></span>
                                </a>
                                <ul class="dropdown-menu" id="notification-menu" role="menu">
                                    <div class="note-header">Notifications</div>
                                </ul>
                            </li>
                            <input type="hidden" id="note-timestamp" value="0">';
                    }
                ?>
                <li <? if($stack==0&&!$stacks) echo 'class="active"'?>><a href="/$best">best</a></li>
                <?
                if(!isset($_COOKIE["nearbyoff"])){
                    if($stack==4917){
                        echo '<li class="active"><a href="../$near">near</a></li>';
                    }else{
                        echo '<li><a href="../$near">near</a></li>';
                    }
                }else{
                    if($login){
                        if($stack==-2){
                            echo '<li class="active"><a href="../$followed">followed</a></li>';
                        }else{
                            echo '<li><a href="../$followed">followed</a></li>';
                        }
                    }else{
                        if($stack==-1){
                            echo '<li class="active"><a href="../$everything">everything</a></li>';
                        }else{
                            echo '<li><a href="../$everything">everything</a></li>';
                        }
                    }
                }
                ?>
                <li <? if($stacks) echo 'class="active"'?>><a href="../stacks"><span class="glyphicon glyphicon-search search" aria-hidden="true"></span> Explore</a></li>
                <? if($login) include_once 'options.php'; else echo '<li><a href="../about">About</a></li>';?>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>
