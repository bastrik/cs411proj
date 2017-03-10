<?php header("access-control-allow-origin: *"); ?>
<form id="commentform">
    <input type="hidden" name="postid" value="<?
    echo $postid;
    ?>">
    <div class="postcon commentbox">
        <div id="textpost">
            <textarea name="text" class="expanding" id="text" placeholder="Write something here..." rows="2" required></textarea>
        </div>
    </div>
    <div class="postsub comsub">
        <label class="commentl">
            <b>Comment</b>
        </label>
        <button type="submit" class="postb commentb mainb">Post</button>
    </div>
</form>
