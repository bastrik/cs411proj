function youtube_parser(url){
    var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/;
    var match = url.match(regExp);
    if (match&&match[7].length==11){
        return match[7];
    }else{
        //alert("Url incorrecta");
    }
}
function getlink(el, link){
    if(post){
        return link;
    }

    return '/p/'+el;
}
function comments(element){
    var del = '';
    if(element.delete){
        del = '<a class="delete commentlink" data-delete="'+element.post_id+'"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>';
    }if(element.report==1){
        del += '<a class="report commentlink" data-delete="'+element.post_id+'"><span class="glyphicon glyphicon-flag" aria-hidden="true"></span></a>';
    }
    if(!post){
        return '<div class="commentcon"><a class="commentlink" target="_blank" href="/p/'+element.post_id+'">'+element.comments+' comments</a>'+del+'<span class="pid">P#'+element.post_id+'</span></div>';
    }else{
        return '<div class="commentcon">'+del+'<span class="pid">P#'+element.post_id+'</span></div>';
    }
}
function priv(priv, nsfw){
    var classes = "";
    if(priv == "1"){
        classes = classes + "privatepost ";
    }
    if(nsfw==1){
        classes = classes + "nsfw";
    }else if(nsfw==2){
        classes = classes + "nsfw gore";
    }else if(nsfw>2){
        classes = classes + "nsfw boobs";
    }
    return classes;
}
var entityMap = {
    "&": "&amp;",
    "<": "&lt;",
    ">": "&gt;",
    '"': '&quot;',
    "'": '&#39;',
    "/": '&#x2F;'
};

function escapeHtml(string) {
    return String(string).replace(/[&<>"'\/]/g, function (s) {
        return entityMap[s];
    });
}
function replaceAll(find, replace, str) {
    return str.replace(new RegExp(find, 'g'), replace);
}
function privt(title, private){
    var re = title;
    if(private=="1"){
        re = '<span class="glyphicon glyphicon-lock" aria-hidden="true"></span> '+re;
    }
    return re;
}
function voting(votetype, count){
    var re = '<div class="vbutton stackup glyphicon glyphicon-triangle-top" name="up"></div>'+
        '<p class="count">'+count+'</p>'+
        '<div class="vbutton stackdown glyphicon glyphicon-triangle-bottom" name="down"></div>';
    if(votetype == 0){
        re = '<div class="vbutton stackup glyphicon glyphicon-triangle-top" name="up"></div>'+
        '<p class="count">'+count+'</p>'+
        '<div class="vbutton stackdown stack-down glyphicon glyphicon-triangle-bottom" name="down"></div>';
    }else if(votetype == 2){
        re = '<div class="vbutton stackup stack-up glyphicon glyphicon-triangle-top" name="up"></div>'+
        '<p class="count">'+count+'</p>'+
        '<div class="vbutton stackdown glyphicon glyphicon-triangle-bottom" name="down"></div>';
    }
    return re;
}
function seeMore() {
    document.getElementsByClassName("imagewrap").style.maxHeight = "100px";
    document.getElementsByClassName("imagewrap").style.overflow = "visible";
}
function imagepost(element){
    var count = element.upstacks-element.downstacks;
    var vote = voting(element.vote, count);
    var stack_name;
    var imgheight = 700;
    if(stackid>0&&stackid!=4917&&!isuser){
        stack_name = '';
    }else{
        if(element.stackname.charAt(0)=="$"){
            stack_name = ' to <a href="https://stacksity.com/'+ element.stackname+'">'+element.stackname+'</a>';
        }else{
            if(element.username==element.stackname){
                stack_name = ' to self';
            }else{
                stack_name = ' to <a href="https://stacksity.com/u/'+ element.stack_id+'">'+element.stackname+element.stackflair+'</a>';
            }
        }
    }

    // Check image heights as every image loads in feed
    $("<img>").attr("src", element.link).load(function(){
        // Gets the height of the img element

        //If img height is small enough, don't display "Expand" button
        //if(post){
        //    $("#imgid"+element.post_id).parent().addClass("imgexpanded");
        //}else{
            imgheight = $("#imgid"+element.post_id).children("img").height();
            if(imgheight > 1500 ) {
                $("#imgid"+element.post_id).parent().after('<div class="imgpreviewdiv expandimg">Expand</div>');
            }
        //}
    });

    return '<div class="item ipost '+priv(element.private, element.nsfw)+'" id="'+element.post_id+'">' +
    '<div class="textcon">' +
    '<div><span class="expandicon glyphicon glyphicon-plus-sign"></span><p><a href="https://stacksity.com/u/'+ element.poster_id+'">'+ element.username + element.flair + '</a> '+stack_name+' | '+ element.created +'</p></div>' +
    '<a href="'+getlink(element.post_id, element.link)+'" target="_blank" style="text-decoration: none"><h4>' + privt(element.title, element.private) + '</h4></a>' +
    '<div class="collapsecon">' +
    '<a class="fancybox" rel="group" href="'+element.link+'" title="'+element.title+'" alt="'+element.title+'">' +
        //'<script>$(".fancybox").last().fancybox({openEffect:"fade",closeEffect: "fade",padding : 0,loop: false, title: "<a href='+getlink(element.post_id, element.link)+'>'+element.title+'</a>"});</script>'+
    '<div class="imagewrap" id="imgid'+element.post_id+'">' + element.embed+ '</div>' +
    '</a>' +
    '<div class="textfeed"></div></div>'+comments(element)+
        /*'<p class="link">'+link.substring(0,100)+'</p><a href="'+element.link+'">See More</a>'+*/
    '</div>' +
    '<div class="vote login">'+
    vote +
    '</div>'+
    '</div>';
}

//$(document).on("click", ".imagecon", function() {
//    $(".fancyboxlink").attr("href", "http://google.com");
//});

// Image Expand Function (Young)

// Mobile Tap Setup
$('.expandimg').css('cursor','pointer');
$('.expandedimg').css('cursor','pointer');

// When clicking and expanding image
$(document).on("click", ".expandimg", function (event) {
    event.preventDefault();
    $(this).parent().children(".fancybox").children(".imagewrap").addClass("imgexpanded");
    $(this).addClass("expandedimg");
    $(this).removeClass("expandimg");
    this.innerHTML = "Close";
});

// When clicking an already expanded image
$(document).on("click", ".expandedimg", function (event) {
    event.preventDefault();
    $(this).parent().children(".fancybox").children(".imagewrap").removeClass("imgexpanded");
    $(this).addClass("expandimg");
    $(this).removeClass("expandedimg");
    this.innerHTML = "Expand";
});

// End of Image Expand Function

function videopost(element){
    var count = element.upstacks-element.downstacks;
    var vote = voting(element.vote, count);
    var stack_name;
    if(stackid>0&&stackid!=4917&&!isuser){
        stack_name = '';
    }else{
        if(element.stackname.charAt(0)=="$"){
            stack_name = ' to <a href="https://stacksity.com/'+ element.stackname+'">'+element.stackname+'</a>';
        }else{
            if(element.username==element.stackname){
                stack_name = ' to self';
            }else{
                stack_name = ' to <a href="https://stacksity.com/u/'+ element.stack_id+'">'+element.stackname+element.stackflair+'</a>';
            }
        }
    }
    console.log(post);
    return '<div class="item vpost '+priv(element.private, element.nsfw)+'" id="'+element.post_id+'">' +
    '<div class="textcon">' +
    '<div><span class="expandicon glyphicon glyphicon-plus-sign"></span><p><a href="https://stacksity.com/u/'+ element.poster_id+'">'+ element.username + element.flair + '</a> '+stack_name+' | '+ element.created +'</p></div>' +
    //'<p><a href="https://stacksity.com/u/'+ element.poster_id+'">'+ element.username + element.flair + '</a> '+stack_name+' | '+ element.created +'</p>' +
    //'<a href="'+element.link+'" target="_blank">' +
    '<a href="'+getlink(element.post_id, element.link)+'" target="_blank" style="text-decoration: none"><h4>' + privt(element.title, element.private) + '</h4></a>' +
    '<div class="linkwrapper collapsecon"><div class="videowrapper">'+element.embed+'</div>'+
    '<div class="infofeed"><p class="content">'+element.text+'</p></div></div>'+comments(element)+
    '</div>' +
    '<div class="vote login">'+
    vote +
    '</div>'+
    '</div>';
}
function linkspost(element){
    var count = element.upstacks-element.downstacks;
    var vote = voting(element.vote, count);
    var stack_name;
    if(stackid>0&&stackid!=4917&&!isuser){
        stack_name = '';
    }else{
        if(element.stackname.charAt(0)=="$"){
            stack_name = ' to <a href="https://stacksity.com/'+ element.stackname+'">'+element.stackname+'</a>';
        }else{
            if(element.username==element.stackname){
                stack_name = ' to self';
            }else{
                stack_name = ' to <a href="https://stacksity.com/u/'+ element.stack_id+'">'+element.stackname+element.stackflair+'</a>';
            }
        }
    }
    return '<div class="item lpost '+priv(element.private, element.nsfw)+'" id="'+element.post_id+'">' +
    '<div class="textcon">' +
    '<div><span class="expandicon glyphicon glyphicon-plus-sign"></span><p><a href="https://stacksity.com/u/'+ element.poster_id+'">'+ element.username + element.flair + '</a> '+stack_name+' | '+ element.created +'</p></div>' +
    '<a href="'+getlink(element.post_id, element.link)+'" target="_blank" style="text-decoration: none"><h4>' + privt(element.title, element.private) + '</h4></a>' +
    '<div class="linkwrapper collapsecon"><a href="'+element.link+'" target="_blank">' +
    '<div class="linkcon"></div><div class="linkcontainer"><img class="linkimage" src="'+ element.image +'"></div>' +
    '</a>' +
    '<p class="content">'+element.text+'</p></div>'+comments(element)+'</div>'+
    '<div class="vote login">'+
    vote +
    '</div>'+
    '</div>'
}
function textspost(element){
    //alert(element.text);
    var count = element.upstacks-element.downstacks;
    var vote = voting(element.vote, count);
    var stack_name;
    if(stackid>0&&stackid!=4917&&!isuser){
        stack_name = '';
    }else{
        if(element.stackname.charAt(0)=="$"){
            stack_name = ' to <a href="https://stacksity.com/'+ element.stackname+'">'+element.stackname+'</a>';
        }else{
            if(element.username==element.stackname){
                stack_name = ' to self';
            }else{
                stack_name = ' to <a href="https://stacksity.com/u/'+ element.stack_id+'">'+element.stackname+element.stackflair+'</a>';
            }
        }
    }
    var link;
    if(post){
        link = '<h4>' + privt(element.title, element.private) + '</h4>';
    }else{
        link =   '<a href="'+getlink(element.post_id, element.link)+'" target="_blank" style="text-decoration: none"><h4>' + privt(element.title, element.private) + '</h4></a>';
    }
    return '<div class="item tpost '+priv(element.private, element.nsfw)+'" id="'+element.post_id+'">' +
    '<div class="textcon">' +
    '<div><span class="expandicon glyphicon glyphicon-plus-sign"></span><p><a href="https://stacksity.com/u/'+ element.poster_id+'">'+ element.username + element.flair +
    '</a>'+stack_name + ' | '+ element.created +'</p></div>' +
    link +
    '<div class="content collapsecon textpostcon">'+ element.text +'</div>' +comments(element)+
    '</div>' +
    '<div class="vote login">'+
    vote +
    '</div>'+
    '</div>';
}/**
 * Created by killswitch on 3/21/2015.
 */

String.prototype.replaceAll = function(search, replace) {
    if (replace === undefined) {
        return this.toString();
    }
    return this.split(search).join(replace);
};

var delete_id = 0;
$(document).on('click', '.delete', function(e) {
        delete_id = $(this).data('delete');
        $('#delpost').modal({keyboard: true});
        return false;
    });
$('#deletelink').click(function(e){
    $.ajax({
        type     : "POST",
        cache    : false,
        url      : '/php/deletepost.php',
        data     : {delid : delete_id},
        success  : function(data) {
            if(data==0){
                $('#'+delete_id).fadeOut();
            }else{
                alert(data);
            }
            $('#delpost').modal('hide');
        },
        error: function(xhr, status, error) {
            alert("error"+ xhr.responseText);
            $('#delpost').modal('hide');
        }
    });
});

var report_id = 0;
$(document).on('click', '.report', function(e) {
    report_id = $(this).data('delete');
    $('#repost').modal({keyboard: true});
    return false;
});
$(document).on('click', '.expandicon', function(e) {
    $(this).parent().siblings(".collapsecon").toggle();
});
$('#reportlink').click(function(e){
    $.ajax({
        type     : "POST",
        cache    : false,
        url      : '/php/reportpost.php',
        data     : {relid : report_id},
        success  : function(data) {
            if(data==0){
                $('#'+report_id).fadeOut();
                alert("Your report has been submitted and will be reviewed by the admins.");
            }else{
                alert(data);
            }
            $('#repost').modal('hide')
        },
        error: function(xhr, status, error) {
            alert("error"+ xhr.responseText);
            $('#repost').modal('hide');
        }
    });
});