/**
 * Created by Tyler on 1/19/2015.
 */
var self = $('#selfid').html();
var stackname = $('#stackname').val();
var stackid = $('#stack').val();
var isuser = false;
if($('#isuser').val() == 1){
    isuser = true
}
var post = false;
linkpost();
name();

function name(){
    if(stackid < 1){
        $("#posting").html("yourself");
    }else if(stackid == 4917){
        $("#posting").html("nearby");
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
    $('#postimage').removeClass('active');
    $('#posttext').removeClass('active');
    $('#postlink').addClass('active');
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
    $("#link").val('');
}
function imagepostShow(){
    $("#text").prop('required', false);
    $("#image").prop('required', true);
    $("#link").prop('required', true);
    $('#posttype').val("0");
    $('#linkpost').hide();
    $('#textpost').hide();
    //$("#link").val('');
    $('#imagepost').show();

    $('#posttext').removeClass('active');
    $('#postimage').addClass('active');
    $('#postlink').removeClass('active');
}
$( "#title-input" ).keyup(function() {
    var length = $( this ).val().length;
    $( "#title-count").html(100-length);
});

function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + "; " + expires;
}

var bottom = false;
var startnews = 0;
var loading = false;
var loclat=null, loclong=null;
var end = false;
var globaldist = 0;
var stat = 0;

function checkEnd(postnum){
    if(postnum == 0 || postnum < 10){
        end = true;
        $('.scroll').html('<p>No more posts</p>');
    }
}

function checkLocation(){
    var myCookie = getCookie("nearbyoff");
    if(myCookie == null) {
        return true;
    }return false;
}
if(stackid==4917){
    globaldist = 5.0;
    startLocNews(5.0);
}else{
    startNews(startnews);
}

//this function is called when someone fires a change distance button
function setDist(distance, button){
    $(".dist-btn").prop('disabled', false);
    $(button).prop('disabled', true);
    bottom = false;
    startnews = 0;
    loading = false;
    loclat=null;
    loclong=null;
    end = false;
    $("#feed").empty();
    $('.scroll').html('<p>Loading Posts</p> <div class="loader" style="top: -35px">Loading...</div>');
    globaldist = distance;
    if(distance==0){
        startNews(startnews);
    }else{
        startLocNews(distance);
    }
}
//this function refreshes the newsfeed based on geographic location, distance is the radius extending from user in kilometers to search for nearby posts
function startLocNews(distance){
    //the checklocation function ensures that the geolocation feature is turned ons
    if(checkLocation()){
        navigator.geolocation.getCurrentPosition(function(pos) {
            //startnews has to be inside as a function because the function is asynchronous and won't store into local variables
            startNews(startnews, pos.coords.latitude, pos.coords.longitude, distance);
        },function(error){
            alert(error+"...Please allow Stacksity to access your location to see nearby posts");
            //window.location.replace("/$best");
        });
    }else{
        window.location.replace("/$best");
    }
}

function startNews(startnum, latpoint, longpoint, dist) {
    if(!loading){
        if(end){
            return;
        }
        var postnum = 0;
        loading = true;
        if(loclong==null&&loclat==null){
            loclat = latpoint;
            loclong = longpoint;
        }
        /*the following is a test script to get server responses from feed.php to find errors*/
        //$.ajax({
        //    type     : "GET",
        //    cache    : false,
        //    url      : '../php/feed.php',
        //    data     : {id : stackid , start : startnum, longitude : loclong, latitude : loclat, distance : dist, status: stat},
        //    success  : function(data) {
        //        console.log(data);
        //    },
        //    error: function(xhr, status, error) {
        //        alert("error"+ xhr.responseText);
        //        $('.postb').html('Post');
        //        $('#private').html('Private');
        //        posting = false;
        //    }
        //});
        //alert(dist + " " + startnum)
        $.getJSON('../php/feed.php', {id : stackid , start : startnum, latitude : loclat, longitude : loclong, distance : dist, status: stat}, function(data){
            if(null==data){
                checkEnd(postnum);
            }else{
                if(startnum==0){
                    $("#feed").empty();
                }
                var postlist = "";
                var existingPost = {};
                $(".item").each(function() {
                    existingPost[$(this).attr("id")] = null;
                });
                $.each(data, function(index, element) {
                    if(!(parseInt(element.post_id) in existingPost)){
                        if(element.posttype == 0){
                            postlist += linkspost(element);
                        }else if(element.posttype == 1){
                            postlist += textspost(element);
                        }else if(element.posttype == 2){
                            postlist += imagepost(element);
                        }else if(element.posttype == 3){
                            postlist += videopost(element);
                        }
                    }
                    postnum++;
                });
                $('#feed').append(postlist);
                $(".fancybox").fancybox({
                    openEffect:"none",
                    closeEffect: "none",
                    padding : 0
                });
                //if(data.length>0){
                //    $("#feed").append('<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>'+
                //    '<ins class="adsbygoogle"'+
                //    'style="display:block"'+
                //    'data-ad-client="ca-pub-4753714915896025"'+
                //    'data-ad-slot="3281534396"'+
                //    'data-ad-format="auto"></ins>'+
                //        '<script>'+
                //        '(adsbygoogle = window.adsbygoogle || []).push({});'+
                //'</script>')
                //}
                loading = false;
                startnews = startnews + 10;
                bottom = false;
                checkEnd(postnum);
            }
        });
    }
}

$(window).scroll(function() {
    if($(window).scrollTop() + $(window).height() > $(document).height() - 2000) {
        if(!end&&!bottom){
            bottom = true;
            $('.scroll').html('<p>Loading Posts</p> <div class="loader" style="top: -35px">Loading...</div>');
            if(globaldist==0){
                startNews(startnews);
            }else{
                startLocNews(globaldist)
            }
        }
    }
});
var posting  = false;
$("#private").click( function(e){
    e.preventDefault();
    $('#privatefield').val(1);
    $("#toppost").submit();
});
$("#exclude").click( function(e){
    e.preventDefault();
    $('#privatefield').val(1);
    $("#toppost").submit();
});
$("#toppost").on('submit', function(e){
    e.preventDefault();
        navigator.geolocation.getCurrentPosition(function(position){
                makepost("&lat="+position.coords.latitude+"&long="+position.coords.longitude);
            },
            function(error){
                makepost();
            }
        );
});
$("#bioedit").click(function(){
    $('#editbiography').modal('show');
});
$('#editbio').on("submit", function(e){
    e.preventDefault();
    var text = $("#biocontent").val();
    $.ajax({
        type     : "POST",
        cache    : false,
        url      : '../php/bio.php',
        data     : {name: text},
        success: function(data){
            $('#bio').html(text);
            $('#editbiography').modal('hide');
        },
        error: function(xhr, status, error) {
            alert("error"+ xhr.responseText);
        }
    });
});
function makepost(info){
    if(!posting){
        posting = true;
        $('.postb').html('<div class="loader">Loading...</div>');
        if(typeof info === "undefined"){
            var send = $("#toppost").serialize();
        }else{
            var send = $("#toppost").serialize()+info;
        }
        //alert(send);
        $.ajax({
            type     : "POST",
            cache    : false,
            url      : '/php/post.php',
            data     : send,
            success  : function(data) {
                //alert(data);
                if(data.length<=2) {
                    if(data==4){
                        alert("Please fill out all fields")
                    }else if(data!=3){
                        alert("error :" + data);
                    }
                }else{
                    $('.background-image').hide();
                    $('#toppost').trigger("reset");
                    $( "#title-count").html("100");
                    var element = $.parseJSON(data);
                    if(element.posttype == 0){
                        $(linkspost(element)).hide().prependTo('#feed').fadeIn("slow");
                    }else if(element.posttype == 1){
                        $("#text").val('').change();
                        $(textspost(element)).hide().prependTo('#feed').fadeIn("slow");
                    }else if(element.posttype == 2){
                        $(imagepost(element)).hide().prependTo('#feed').fadeIn("slow");
                    }else if(element.posttype == 3){
                        $(videopost(element)).hide().prependTo('#feed').fadeIn("slow");
                    }
                }
                $('.postb').html('Post');
                $('#private').html('Private');
                $('#exclude').html('Exclude');
                $('#privatefield').val(0);
                posting = false;
            },
            error: function(xhr, status, error) {
                alert("error"+ xhr.responseText);
                $('.postb').html('Post');
                $('#private').html('Private');
                $('#exclude').html('Exclude');
                posting = false;
            }
        });
    }
}
$( ".nsfwop" ).click(function() {
    $("#nsfwstatus").html($(this).html());
    var val = $(this).data("value");
    if(val>0){
        $("#nsfwstatus").addClass("nsfwl");
    }else{
        $("#nsfwstatus").removeClass("nsfwl");
    }
    $("#nsfwval").val(val);
});
$( ".follow" ).click(function() {
    if($(this).val()==1){
        $(this).val(0);
        $(this).removeClass('followed');
        $(this).html('Follow');
        $("#followers").html(parseInt($("#followers").html())-1);
    }else{
        $(this).addClass('followed');
        $(this).html('Followed');
        $(this).val(1);
        $("#followers").html(parseInt($("#followers").html())+1);
    }
    $.ajax({
        type     : "POST",
        cache    : false,
        url      : '/php/follow.php',
        data     : { stack: stackid},
        success: function(data){
        },
        error: function(xhr, status, error) {
            alert("error"+ xhr.responseText);
        }
    });
});
/* Drag'n drop stuff */
window.ondragover = function(e) {e.preventDefault()}
window.ondrop = function(e) {e.preventDefault(); upload(e.dataTransfer.files[0]); }

function upload(file) {

    /* Is the file an image? */
    if (!file || !file.type.match(/image.*/)) return;
    /* It is! */
    document.body.className = "uploading";
    $('#imageid').val("uploading...");
    var fd = new FormData(); // I wrote about it: https://hacks.mozilla.org/2011/01/how-to-develop-a-html5-image-uploader/
    fd.append("fileToUpload", file); // Append the file
    var xhr = new XMLHttpRequest(); // Create the XHR (Cross-Domain XHR FTW!!!) Thank you sooooo much imgur.com
    xhr.open("POST", "https://phify.com/uploadapi.php"); // Boooom!
    xhr.onload = function() {
        // Big win!
        var link = xhr.responseText;
        $('#link').val(link);
        $('#imageid').val(file.name);
        $('#imagePostPreview').attr('src', link);
        $('.background-image').show();
        document.body.className = "uploaded";
    };

    //$.ajax({
    //    url: "http://phify.com/uploadapi.php",
    //    type: 'POST',
    //    data: data,
    //    processData: false,
    //    contentType: false,       // The content type used when sending data to the server.
    //    crossDomain: true,
    //    success: function(data)   // A function to be called if request succeeds
    //    {
    //        alert("sadsadsadsadsadsadsadasdsadsdsadsa");
    //        var link = data;
    //        $('#link').val(link);
    //        $('#imageid').val(file.name);
    //        $('#imagePostPreview').attr('src', link);
    //        $('.background-image').show();
    //        document.body.className = "uploaded";
    //    },
    //    error: function(error){
    //        alert(error);
    //    }
    //});

    // Ok, I don't handle the errors. An exercise for the reader.
    /* And now, we send the formdata */
    xhr.send(fd);
}
//function upload(file) {
//    /* Is the file an image? */
//    if (!file || !file.type.match(/image.*/)) return;
//    /* It is! */
//    var data = new FormData(); // I wrote about it: https://hacks.mozilla.org/2011/01/how-to-develop-a-html5-image-uploader/
//    data.append("image", file); // Append the file
//
//    document.body.className = "uploading";
//    $('#imageid').val("uploading...");
//    /* Lets build a FormData object*/
//    $.ajax({
//        url: "http://phify.com/uploadapi.php",
//        type: 'POST',
//        data: data,
//        processData: false,
//        contentType: false,       // The content type used when sending data to the server.
//        success: function(data)   // A function to be called if request succeeds
//        {
//            alert(data);
//            var link = $(data).find('link').text();
//            $('#link').val(link);
//            $('#imageid').val(file.name);
//            $('#imagePostPreview').attr('src', link);
//            $('.background-image').show();
//            document.body.className = "uploaded";
//        },
//        error:function(response){
//            alert("Upload error: "+response);
//        }
//    });
//}
function stackTrace() {
    var err = new Error();
    return err.stack;
}
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
function getCookie(name) {
    var dc = document.cookie;
    var prefix = name + "=";
    var begin = dc.indexOf("; " + prefix);
    if (begin == -1) {
        begin = dc.indexOf(prefix);
        if (begin != 0) return null;
    }
    else
    {
        begin += 2;
        var end = document.cookie.indexOf(";", begin);
        if (end == -1) {
            end = dc.length;
        }
    }
    return unescape(dc.substring(begin + prefix.length, end));
}


sidebar = $("#fluidside");
displacement = sidebar.height()+sidebar.offset().top - 60;
//Ensuring that the sidebar is follows the user's scroll past a certain point.
$(window).scroll(function() {
    if ($(window).width() > 991) {
        if ($(window).scrollTop() > displacement) {
            $("#sticky").css("margin-top", ($(window).scrollTop()-displacement)+"px")
        }else{
            $("#sticky").css("margin-top", "0px")
        }
    }
});