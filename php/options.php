<?php //header("access-control-allow-origin: *"); ?>
<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">More<span class="caret"></span></a>
    <ul class="dropdown-menu" role="menu">
        <li><a href="/$everything">everything</a></li>
        <li><a href="/$recent">recent</a></li>
        <li role="separator" class="divider"></li>
        <li><a href="/settings">settings</a></li>
        <? if(isset($_SESSION['admin'])&&$_SESSION['admin']==1){echo '<li><a href="/php/admin.php">admin</a></li>';}?>
        <li><a href="/faq">FAQ</a></li>
        <li><a href="/logout.php">logout</a></li>
    </ul>
</li>
