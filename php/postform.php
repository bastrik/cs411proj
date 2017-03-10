<?php //header("access-control-allow-origin: *"); ?>
<div class="post">
<div class="row postrow posting">
    <a class="col-xs-4 active" onclick="linkpost()" id="postlink">Link</a>
    <a class="col-xs-4" onclick="textpost()" id="posttext">Text</a>
    <a class="col-xs-4" onclick="imagepostShow()" id="postimage">Image</a>
</div>
<form class="postform" id="toppost">
    <input type="hidden" id="posttype" name="type" value="0">
    <input type="hidden" name="stack" value="<?
    if($stack<1){
        echo $_SESSION['stack_id'];
    }else{
        echo $stack;
    }
    ?>">
    <input type="hidden" name="user_value" value="<?
    if($is_user){
        echo "1";
    }else{
        echo "0";
    }
    ?>">
    <div class="postcon">
        <p>caption <span id="title-count">100</span></p>
        <input name="title" type="text" id="title-input" class="texts" placeholder="Post title" maxlength="100">
        <div id="linkpost">
            <p>link <span id="link-alert"></span></p>
            <input name="link" type="url" name="link" id="link" class="texts" placeholder="Submit a link here" maxlength="500">
        </div>
        <div id="textpost" style="display: none">
            <p>text</p>
            <textarea name="text" class="expanding" id="text" placeholder="Write something here..." rows="2" maxlength="6500"></textarea>
        </div>
        <div id="imagepost" style="display: none">
            <p>image</p>
            <div class="input-group">
                <span class="input-group-btn">
                    <span class="btn btn-primary btn-file" id="uploadimage">
                        <span class="glyphicon glyphicon-camera"></span> Browse <input type="file" accept="image/x-png, image/gif, image/jpeg" onchange="upload(this.files[0])">
                    </span>
                </span>
                <input type="text" id="imageid" class="form-control" disabled>
            </div>
            <div class="background-image"><img src="" id="imagePostPreview" class="img-responsive"></div>
<!--            <div class="uploading">upload or drag image here</div>-->
        </div>
    </div>
    <div class="postsub">
        <label>
            Posting to <span class="bold" id="posting">stack</span>
            <!--<input type="checkbox" name="checked" value="remember-me">-->
        </label>
        <input type="hidden" name="setprivate" value="0" id="privatefield"/>
        <input type="hidden" value="0" name="nsfw" id="nsfwval">

        <button type="submit" class="postb">Post</button>
        <?if($is_user){echo '<button type="button" id="private" class="postb private">Private</button>';}
        elseif($stack!=4917){echo '<button type="button" id="exclude" class="postb private">Exclude</button>';}?>
        <?if(isset($_SESSION["nsfw"])&&$_SESSION["nsfw"]>0){
            echo '<div class="dropdown nsfwdown">
            <button class="btn btn-default dropdown-toggle nsfwb" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
                <span id="nsfwstatus">safe</span>
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu dropdown-menu-right nsfwm" role="menu" aria-labelledby="dropdownMenu1">
                <li role="presentation"><a role="menuitem" tabindex="-1" data-value="0" class="nsfwop ">safe</a></li>
                <li role="presentation"><a role="menuitem" tabindex="-1" data-value="1" class="nsfwop nsfwl">nsfw</a></li>
                <li role="presentation"><a role="menuitem" tabindex="-1" data-value="2" class="nsfwop nsfwl">gore</a></li>
                <li role="presentation"><a role="menuitem" tabindex="-1" data-value="3" class="nsfwop nsfwl">nudity</a></li>
            </ul>
        </div>';
        }?>
    </div>
</form>
</div>
