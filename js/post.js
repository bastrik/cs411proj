/**
 * Created by killswitch on 3/21/2015.
 */
var postid = $('#postid').val();
var stackid = 0;
var post = true;
var login = $('#login').val()=='1';
var isuser = false;

var loader =
'<div class="spinner">'+
    '<div class="double-bounce1"></div>'+
    '<div class="double-bounce2"></div>'+
'</div>';

function commentVote(type, count){
    if(type==2){
        return '<div class="cvote"><div class="cbutton glyphicon glyphicon-triangle-top stackup stack-up" name="up"></div><p class="score">'+count+'</p><div class="cbutton glyphicon glyphicon-triangle-bottom stackdown" name="down"></div></div>'
    }
    if(type==0){
        return '<div class="cvote"><div class="cbutton glyphicon glyphicon-triangle-top stackup" name="up"></div><p class="score">'+count+'</p><div class="cbutton glyphicon glyphicon-triangle-bottom stackdown stack-down" name="down"></div></div>'
    }
    return '<div class="cvote"><div class="cbutton glyphicon glyphicon-triangle-top stackup" name="up"></div><p class="score">'+count+'</p><div class="cbutton glyphicon glyphicon-triangle-bottom stackdown" name="down"></div></div>'
}
getPost(postid);
function getPost(postid)
{
    //if(postdata==null){
    //    $.getJSON('https://stacksity.com/php/postname.php', {id : postid}, function(element){
    //        if(null==element){
    //            window.location.replace("../php/postnotfound.html");
    //        }else{
    //            if(element.posttype == 0){
    //                $('#postcon').append(linkspost(element));
    //            }else if(element.posttype == 1){
    //                $('#postcon').append(textspost(element));
    //            }else if(element.posttype == 2){
    //                $('#postcon').append(imagepost(element));
    //            }else if(element.posttype == 3){
    //                $('#postcon').append(videopost(element));
    //            }
    //        }
    //        if(element.comments>0){
    //            $(".commentfeed").html("<div class='commentsload'>Loading Comments...</div>");
    //            getComment($(".commentfeed"));
    //        }else{
    //            $('.commentfeed').append("<div class='nocomments'>No comments currently</div>");
    //        }
    //    });
    //}else{
        var element = postdata;
        if(null==element){
            window.location.replace("../php/postnotfound.html");
        }else{
            if(element.posttype == 0){
                $('#postcon').append(linkspost(element));
            }else if(element.posttype == 1){
                $('#postcon').append(textspost(element));
            }else if(element.posttype == 2){
                $('#postcon').append(imagepost(element));
            }else if(element.posttype == 3){
                $('#postcon').append(videopost(element));
            }
        }
        if(element.comments>0){
            $(".commentfeed").html("<div class='commentsload'>"+loader+"</div>");
            getComment($(".commentfeed"));
        }else{
            $('.commentfeed').append("<div class='nocomments'>No comments currently</div>");
        }
    //}
}
var posting  = false;
$("#commentform").on('submit', function(e){
    e.preventDefault();
    if(!posting){
        posting = true;
        $('.mainb').html('<div class="loader">Loading...</div>');
        e.preventDefault();
        $.ajax({
            type     : "POST",
            cache    : false,
            url      : '../php/postcomment.php',
            data     : $(this).serialize(),
            success  : function(data) {
                console.log(data);
                if(data.length<=1) {
                    if(data!=3){
                        alert("error :" + data);
                    }
                }else{
                    var element = $.parseJSON(data);
                    $(commentHTML(element, 0)).hide().prependTo('.commentfeed').fadeIn("slow");
                    $('.mainb').html('Post');
                    $("#commentform").find("input[type=text], textarea").val("");
                    $(".nocomments").remove();
                }
                posting = false;
            },
            error: function(xhr, status, error) {
                alert("error"+ xhr.responseText);
                $('.mainb').html('Post');
                posting = false;
            }
        });
    }else{
        e.preventDefault();
    }
});
function commentHTML(element, depth){
    var count = element.upstacks-element.downstacks;
    var depthtext = '';
    var del = '';
    var edit = '';
    var edittime = '';
    //alert(element.user_id+" | "+element.user);
    if(element.edit!=null){
        edittime = " | edited "+element.edit;
    }
    if(element.delete){
        del = '<a class="reply editcom">edit</a><a class="reply deletecom" data-delete="'+element.comment_id+'">delete</a>';
        edit = "<form class='editcon' style='display: none'><input name='postid' type='hidden' value='"+postid+"'>"+
        "<input name='commentid' type='hidden' value='"+element.comment_id+"'><textarea name='text'>"+element.raw+"</textarea>"+
        "<a class='reply canceledit'>cancel</a><a class='reply saveedit' onclick='$(this).parent().submit()'>save</a></form>";
    }
    var reply = del;
    if(depth == 0){
        depthtext = 'depth';
    }
    var vote = commentVote(element.vote, count);
    if(depth<7&&login){
        reply = '<a class="reply replybutton" onclick="swapReply(this)">reply</a>'+del+'<form class="replycomment" style="display: none" data-depth="'+depth+'"><div class="postcon replycon">'+
        '<input type="hidden" name="postid" value="'+postid+'">'+
        '<input type="hidden" name="commentid" value="'+element.comment_id+'">'+
        '<div id="textpost">'+
        '<textarea name="text" class="expanding" id="text" placeholder="Write something here..." rows="2" required></textarea>'+
        '</div></div>'+
        '<div class="postsub commentsub"><label class="commentl"><span class="cancelreply" onclick="backReply(this)">Cancel</span></label>'+
        '<button type="submit" class="postb replypost commentb">Post</button>'+
        '</div></form>';
    }
    return '<div class="child '+depthtext+'">'+
    '<div class="comment" data-commentid="'+element.comment_id+'" data-depth="'+element.depth+'">'+
    vote+
    '<div class="comment-content">'+
    '<p class="tagline"><a class="commentcollapse">[–]</a> <a class="comment_link" href="/stack.php?id='+element.user_stack+'" class="">'+element.username+element.flair+'</a> | <time>'+element.created+'</time>' +
    ' | C#'+element.comment_id + "<span class='edittime'>" + edittime +'</span></p>'+
    '<div class="commenttext"><div class="commentcontent">'+element.content +"</div>"+ reply +'</div>'+ edit +
    '</div> </div> </div>';
}

// Comment Collapse Function (Young)

// Detect click of comment collapse <a> tag
$(document).on("click", ".commentcollapse", function (event) {
    event.preventDefault();
    // Set up collapse state variables to keep track of opened/closed comments
    //var collapsestate = 0;
    //var collapsecheck = $(this).attr('class');
    //
    //// Checks if comments have already been collapsed
    //if (collapsecheck == "commentcollapse collapsed") {
    //    collapsestate = 1;
    //} else {
    //    collapsestate = 0;
    //}

    // Depending on whether it's collapsed, expand/collapse the children comments and the comment
    // itself except for the title line with username, etc.
    if ($(this).hasClass("collapsed")) {
        $(this).parent().siblings(".commenttext").slideDown();
        $(this).parent().parent().siblings(".cvote").show();
        $(this).parent().parent().parent().siblings(".child").show();
        this.innerHTML = "[–]";
        $(this).removeClass("collapsed");
        $(this).parent().parent(".comment-content").removeClass("collapsedcss");
        $(this).parent().parent().parent().parent(".child").removeClass("childcollapsed");
    } else {
        $(this).parent().parent().parent().siblings(".child").slideUp();
        $(this).parent().siblings(".commenttext, .editcon").slideUp();
        $(this).parent().parent().siblings(".cvote").hide();
        this.innerHTML = "[+]";
        $(this).addClass("collapsed");
        $(this).parent().parent(".comment-content").addClass("collapsedcss");
        $(this).parent().parent().parent().parent(".child").addClass("childcollapsed");
    }
});

//This function calls the server and gets the comments for the POSTID as a JSON file
function getComment(item)
{
    //this is a test function to get the AJAX response (for debugging purposes)
    //$.ajax({
    //    type     : "GET",
    //    cache    : false,
    //    url      : '../php/commentfeed.php',
    //    data     : {post_id: postid },
    //    success  : function(data) {
    //        alert(data);
    //    }
    //});

    $.getJSON('../php/commentfeed.php', {post_id : postid}, function(data) {
        $(".commentsload").slideUp();
        showComment(data,item);
        //This section checks if there is a link to the comment, and it will highlight and scroll to it
        if($("#comid").length != 0) {
            var cid = $("#comid").val();
            var comment = $(".comment[data-commentid="+cid+"]");
            if(comment.length!=0){
                comment.children(".comment-content").css("background-color","#F0E68C");
                $('html, body').animate({
                    scrollTop: comment.offset().top
                }, 1000);
            }
        }
    });
}

//This function recursively adds in all the comment feed to the actual DOM by parsing the JSON file made by the server
function showComment(data,item){
    $.each(data, function(index, element) {
        item.append(commentHTML(element, element.depth));
        if(element.depth<7){
            if(element.comments!=null) {
                showComment(element.comments, item.children(".child:last"));
            }
        }
    });
}
function swapReply(el){
    if (el.innerHTML == "reply"){
        $(".replycomment").hide();
        $(el).siblings('.replycomment').show();
        el.innerHTML = "cancel";
    } else if (el.innerHTML == "cancel") {
        $(".replycomment").siblings('.reply').show();
        $(el).siblings('.replycomment').hide();
        el.innerHTML = "reply";
    }

}
function backReply(el){
    $(el).closest('.replycomment').siblings('.reply').show();
    $(el).closest('.replycomment').hide();
    $(el).parent().parent().parent().parent().children('.replybutton').text("reply");
}
$(document).on('submit', '.replycomment', function(e){
    e.preventDefault();
    $(this).parent().children('.replybutton').text("reply");
    if(!posting){
        posting = true;
        $(this).children(".commentsub").children('.replypost').html('<div class="loader">Loading...</div>');
        e.preventDefault();
        var el = $(this);
        $.ajax({
            type     : "POST",
            cache    : false,
            url      : '/php/postcomment.php',
            data     : el.serialize(),
            success  : function(data) {
                if(data.length<=1) {
                    if(data!=3){
                        alert("error :" + data);
                    }
                }else{
                    var element = $.parseJSON(data);
                    $(commentHTML(element, el.data('depth')+1)).hide().insertAfter(el.closest('.comment')).fadeIn("slow");
                    el.children('.replypost').html('Post');
                    el.find("input[type=text], textarea").val("");
                    el.siblings('.reply').show();
                    el.hide();
                }
                posting = false;
            },
            error: function(xhr, status, error) {
                alert("error"+ xhr.responseText);
                $(this).children('.replypost').html('Post');
                $(this).siblings('.reply').show();
                $(this).hide();
                posting = false;
            }
        });
    }else{
        e.preventDefault();
    }
});

$(document).on('click', '.editcom', function(e) {
    $(this).parent().siblings().show();
    $(this).parent().hide();
});
$(document).on('click', '.canceledit', function(e) {
    $(this).parent().siblings().show();
    $(this).parent().hide();
});

$(document).on('submit', '.editcon', function(e){
    e.preventDefault();
    if(!posting){
        posting = true;
        $(this).children('.saveedit').html('saving..');
        var el = $(this);
        $.ajax({
            type     : "POST",
            cache    : false,
            url      : '/php/editcomment.php',
            data     : el.serialize(),
            success  : function(data) {
                el.siblings(".commenttext").show();
                el.siblings(".tagline").children(".edittime").html(" | edited now");
                el.siblings().children(".commentcontent").html(data);
                el.hide();
                el.children('.saveedit').html('save');
                posting = false;
            },
            error: function(xhr, status, error) {
                alert("error"+ xhr.responseText);
                el.children('.saveedit').html('save');
                posting = false;
            }
        });
    }else{
        e.preventDefault();
    }
});

var deletecom_id = 0;

$(document).on('click', '.deletecom', function(e) {
    deletecom_id = $(this).data('delete');
    $('#commentdelete').modal({keyboard: true});
    return false;
});
$('#deletecomment').click(function(e){
    $.ajax({
        type     : "POST",
        cache    : false,
        url      : '/php/deletecomment.php',
        data     : {delid : deletecom_id},
        success  : function(data) {
            if(data==0){
                var del = $('*[data-commentid="'+deletecom_id+'"]');
                del.find('.deletecom').remove();
                del.find('.commenttext').html('[deleted]');
            }else{
                alert(data);
            }
            $('#commentdelete').modal('hide');
        },
        error: function(xhr, status, error) {
            alert("error"+ xhr.responseText);
            $('#commentdelete').modal('hide');
        }
    });
});