/**
 * Created by killswitch on 3/19/2015.
 */
/**
 * Created by Tyler on 1/19/2015.
 */
var self = $('#selfid').html();
var stackname = $('#stackname').val();
var stackid = $('#stack').val();
linkpost();
name();
function name(){if(stackid == 0){
    $("#posting").html(self);
}else{
    $("#posting").html(stackname);
}
}

function linkpost(){
    $("#link").prop('required',true);
    $("#image").prop('required',false);
    $("#text").prop('required',false);
    $('#posttype').val("0");
    $('#linkpost').show();
    $('#imagepost').hide();
    $('#textpost').hide();
    $('#postimage').removeClass('active')
    $('#posttext').removeClass('active');
    $('#postlink').addClass('active');;
}
function textpost(){
    $("#text").prop('required',true);
    $("#image").prop('required',false);
    $("#link").prop('required',false);
    $('#posttype').val("1");
    $('#linkpost').hide();
    $('#imagepost').hide();
    $('#textpost').show();
    $('#postimage').removeClass('active');
    $('#posttext').addClass('active');
    $('#postlink').removeClass('active');
    $("#text").expanding();
}
$( "#title-input" ).keyup(function() {
    var length = $( this ).val().length;
    $( "#title-count").html(100-length);
});
function youtube_parser(url){
    var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/;
    var match = url.match(regExp);
    if (match&&match[7].length==11){
        return match[7];
    }else{
        //alert("Url incorrecta");
    }
}
function voting(votetype, count){
    var re = '<div class="vbutton stackup" name="up"></div>'+
        '<p class="count">'+count+'</p>'+
        '<div class="vbutton stackdown" name="down"></div>';
    if(votetype == 0){
        re = '<div class="vbutton stackup" name="up"></div>'+
        '<p class="count">'+count+'</p>'+
        '<div class="vbutton stackdown stack-down" name="down"></div>';
    }else if(votetype == 2){
        re = '<div class="vbutton stackup stack-up" name="up"></div>'+
        '<p class="count">'+count+'</p>'+
        '<div class="vbutton stackdown" name="down"></div>';
    }
    return re;
}
function imagepost(element){
    var count = element.upstacks-element.downstacks;
    if(count < 1){
        count = 1;
    }
    var vote = voting(element.vote, count);
    var stack_name;
    if(stackid != 0){
        stack_name = '';
    }else{
        if(element.username==element.stackname){
            stack_name = ' to <a href="stack.php?id='+ element.stack_id+'">$self</a>';
        }else{
            stack_name = ' to <a href="stack.php?id='+ element.stack_id+'">'+element.stackname+'</a>';
        }
    }
    return '<div class="item" id="'+element.post_id+'">' +
    '<div class="vote login">'+
    vote +
    '</div>'+
    '<div class="textcon">' +
    '<a href="'+element.link+'" target="_blank" style="text-decoration: none"><h4>' + element.title + '</h4></a>' +
    '<p><a href="stack.php?id='+ element.poster_id+'">'+ element.username + '</a> '+stack_name+' | '+ element.created +'</p>' +
    '<a href="'+element.link+'" target="_blank">' +
    '<div class="imagewrap"><img class="imagecon" src="'+ element.link +'"></div>' +
    '</a>' +
    '<div class="textfeed"><p class="content">'+element.text+'</p></div>'+
        /*'<p class="link">'+link.substring(0,100)+'</p>'+*/
    '</div>' +
    '</div>'
}
function videopost(element){
    var count = element.upstacks-element.downstacks;
    if(count < 1){
        count = 1;
    }
    var vote = voting(element.vote, count);
    var stack_name;
    if(stackid != 0){
        stack_name = '';
    }else{
        if(element.username==element.stackname){
            stack_name = ' to <a href="stack.php?id='+ element.stack_id+'">$self</a>';
        }else{
            stack_name = ' to <a href="stack.php?id='+ element.stack_id+'">'+element.stackname+'</a>';
        }
    }

    return '<div class="item" id="'+element.post_id+'">' +
    '<div class="vote login">'+
    vote +
    '</div>'+
    '<div class="textcon">' +
    '<a href="'+element.link+'" target="_blank" style="text-decoration: none"><h4>' + element.title + '</h4></a>' +
    '<p><a href="stack.php?id='+ element.poster_id+'">'+ element.username + '</a> '+stack_name+' | '+ element.created +'</p>' +
    '<a href="'+element.link+'" target="_blank">' +
    '<div class="videowrapper"><iframe class="videoplayer" id="ytplayer" type="text/html" src="https://www.youtube.com/embed/' +
    youtube_parser(element.link)+
    '" frameborder="0" allowfullscreen/></div>'+
    '<div class="textfeed"><p class="content">'+element.text+'</p></div>'+
    '</div>' +
    '</div>';
    return youtube_parser(element.link);
}
function linkspost(element){
    var count = element.upstacks-element.downstacks;
    if(count < 1){
        count = 1;
    }
    var vote = voting(element.vote, count);
    var stack_name;
    if(stackid != 0){
        stack_name = '';
    }else{
        if(element.username==element.stackname){
            stack_name = ' to <a href="stack.php?id='+ element.stack_id+'">$self</a>';
        }else{
            stack_name = ' to <a href="stack.php?id='+ element.stack_id+'">'+element.stackname+'</a>';
        }
    }
    return '<div class="item" id="'+element.post_id+'">' +
    '<div class="vote login">'+
    vote +
    '</div>'+
    '<div class="textcon">' +
    '<a href="'+element.link+'" target="_blank" style="text-decoration: none"><h4>' + element.title + '</h4></a>' +
    '<p><a href="stack.php?id='+ element.poster_id+'">'+ element.username + '</a> '+stack_name+' | '+ element.created +'</p>' +
    '<a href="'+element.link+'" target="_blank">' +
    '<div class="linkcon"></div><div class="linkcontainer"><img class="linkimage" src="'+ element.image +'"></div>' +
    '</a>' +
    '<p class="content">'+element.text+'</p></div>'+
    '</div>' +
    '</div>'
}
function textspost(element){
    var count = element.upstacks-element.downstacks;
    if(count < 1){
        count = 1;
    }
    var vote = voting(element.vote, count);
    var stack_name;
    if(stackid != 0){
        stack_name = '';
    }else{
        if(element.username==element.stackname){
            stack_name = ' to <a href="stack.php?id='+ element.stack_id+'">$self</a>';
        }else{
            stack_name = ' to <a href="stack.php?id='+ element.stack_id+'">'+element.stackname+'</a>';
        }
    }
    return '<div class="item" id="'+element.post_id+'">' +
    '<div class="vote login">'+
    vote +
    '</div>'+
    '<div class="textcon">' +
    '<h4>' + element.title + '</h4>' +
    '<p><a href="stack.php?id='+ element.poster_id+'">'+ element.username +
    '</a>'+stack_name +' | '+ element.created +'</p>' +
    '<p class="content">'+element.text+'</p>' +
    '</div>' +
    '</div>';
}
startNews(0);
function startNews(startnum)
{
    $.getJSON('php/feed.php', {id : stackid , start : startnum }, function(data) {
        $.each(data, function(index, element) {
            if(element.posttype == 0){
                $('#feed').append(linkspost(element));
            }else if(element.posttype == 1){
                $('#feed').append(textspost(element));
            }else if(element.posttype == 2){
                $('#feed').append(imagepost(element));
            }else if(element.posttype == 3){
                $('#feed').append(videopost(element));
            }
        });
    });
}
$(document).on('click', '.vbutton', function(){
    var id = $(this).closest('.item').attr("id");
    var name = $(this).attr("name");
    var dataString = 'id='+ id ;
    var parent = $(this);
    var votes = parseInt(parent.siblings(".count").html());
    if (name=='up') {
        if(parent.hasClass('stack-up')){
            parent.siblings(".count").html(votes-1);
            parent.removeClass('stack-up');
        }else{
            var x = parent.siblings(".stackdown");
            if(x.hasClass('stack-down')){
                if(votes!=1){
                    parent.siblings(".count").html(votes+2);
                }else{
                    parent.siblings(".count").html(votes+1);
                }
                x.removeClass('stack-down');
                parent.addClass('stack-up');
            }else{
                parent.siblings(".count").html(votes+1);
                parent.addClass('stack-up');
            }
        }
        $.ajax({
            type: "POST",
            url: "php/stackup.php",
            data: dataString,
            cache: false,

            success: function(data){
            }
        });
    }else{
        if(parent.hasClass('stack-down')){
            if(votes>1){
                parent.siblings(".count").html(votes+1);
            }
            parent.removeClass('stack-down');
        }else{
            var x = parent.siblings(".stackup");
            if(x.hasClass('stack-up')){
                if(votes>2){
                    parent.siblings(".count").html(votes-2);
                }else{
                    parent.siblings(".count").html(1);
                }
                x.removeClass('stack-up');
                parent.addClass('stack-down');
            }else{
                if(votes>1){
                    parent.siblings(".count").html(votes-1);
                }
                parent.addClass('stack-down');
            }
        }
        $.ajax({
            type: "POST",
            url: "php/stackdown.php",
            data: dataString,
            cache: false,

            success: function(html)
            {
            }
        });
    }
    return false;
});
var posting  = false;
$("#toppost").on('submit', function(e){
    e.preventDefault();
    $('.postb').html('<div class="loader">Loading...</div>');
    if(!posting){
        posting = true;
        $('.postb').html('<div class="loader">Loading...</div>');
        e.preventDefault();
        $.ajax({
            type     : "POST",
            cache    : false,
            url      : 'php/post.php',
            data     : $(this).serialize(),
            success  : function(data) {
                if(data.length<=1) {
                    alert("error :" + data);
                }else{
                    $('#toppost').trigger("reset");
                    $( "#title-count").html("100");
                    var element = $.parseJSON(data);
                    if(element.posttype == 0){
                        $(linkspost(element)).hide().prependTo('#feed').fadeIn("slow");
                    }else if(element.posttype == 1){
                        $(textspost(element)).hide().prependTo('#feed').fadeIn("slow");
                    }else if(element.posttype == 2){
                        $(imagepost(element)).hide().prependTo('#feed').fadeIn("slow");
                    }else if(element.posttype == 3){
                        $(videopost(element)).hide().prependTo('#feed').fadeIn("slow");
                    }
                }
                $('.postb').html('Post');
                posting = false;
            },
            error: function(xhr, status, error) {
                alert("error"+ xhr.responseText);
                $('.postb').html('Post');
                posting = false;
            }
        });
    }else{
        e.preventDefault();
    }
});
/*function imagepost(){
 $("#image").prop('required',true);
 $("#link").prop('required',false);
 $("#text").prop('required',false);
 $('#posttype').val("2");
 $('#linkpost').hide();
 $('#imagepost').show();
 $('#textpost').hide();
 $('#postimage').addClass('active');
 $('#posttext').removeClass('active');
 $('#postlink').removeClass('active');
 }*/