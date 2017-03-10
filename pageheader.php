<!-- Fixed navbar -->
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="stack.php">STACKSITY</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li <? if ($page == 1){ echo "class='active'";}?>><a href="/home">Home</a></li>
                    <li><a href="/$best">best</a></li>
                    <li <? if ($page == 2){ echo "class='active'";}?>><a href="/about">About</a></li>
                    <li class="dropdown <? if ($page == 4){ echo "active";}?>">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Support <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="forgot_password.php">Forgot Password</a></li>
                            <!--<li><a href="forgot_email.php">Forgot Email</a></li>-->
                            <li class="divider"></li>
                            <li class="dropdown-header">Technical Support</li>
                            <li><a href="reportproblem.php">Report a Problem</a></li>
                        </ul>
                    </li>
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </nav>
    <div class="headergap"></div>