/**
 * Created by killswitch on 1/16/2015.

function slick(){
    $("#login").slideUp();
    $("#signin").slideDown();
}
function signin(){
    $("#signin").slideUp();
    $(".alert").slideUp();
    $("#login").slideDown();
}*/
function success(){
    $("#info").slideUp();
    $("#form2head").html("Congrats, you're signed up!");
    $("#inforeg").show();
}
$("#account").on('submit', function(e){
    e.preventDefault();
    if($('#inputPassword').val().length<7){
        $('#pass-alert').slideDown();
    }else{
        $.ajax({
            type     : "POST",
            cache    : false,
            url      : 'php/payment.php',
            data     : $(this).serialize(),
            dataType : "text",
            success  : function(data) {
                if(data=="3"){
                    success();
                }else if(data=="2"){
                    $('#user-alert').slideDown();
                }else if(data=="1"){
                    $('#email-alert').slideDown();
                }else if(data=='10'){
                    $('#reference').html("No spaces in your username please");
                    $('#pass-alert').slideDown();
                }else if(data=='11'){
                    $('#reference').html("Usernames can't start with $");
                    $('#pass-alert').slideDown();
                }else if(data=='12'){
                    $('#reference').html("Usernames can't be only numbers");
                    $('#pass-alert').slideDown();
                }else if(data=='13'){
                    $('#reference').html("Usernames can't have special characters");
                    $('#pass-alert').slideDown();
                }else if(data=='4'){
                    $('#reference').html("You've entered the reCAPTCHA wrong");
                    $('#pass-alert').slideDown();
                }else{
                    $('#reference').html("Oops something went wrong with the server, error code: "+data);
                    $('#pass-alert').slideDown();
                }
            },
            error: function(xhr, status, error) {
                alert(xhr.responseText);
            }
        });
    }
});

$("#login").on('submit', function(e){
    e.preventDefault();
    $.ajax({
        type     : "POST",
        cache    : false,
        url      : 'login.php',
        data     : $(this).serialize(),
        success  : function(data) {
            if(data=="1"){
                $('#ref').html("That username doesn't seem to exist D:");
                $('#login-alert').slideDown();
            }else if(data=="2"){
                $('#ref').html("Password doesn't match username :/");
                $('#login-alert').slideDown();
            }else if(data.length>2){
                document.location.href = '../$best';
            }else{
                $('#ref').html("Oops something went wrong with the server, error code: " + data);
                $('#login-alert').slideDown();
            }
        },
        error: function(xhr, status, error) {
            alert("error: "+xhr.responseText);
        }
    });
});

function slideout(x){
    $('#'+x).slideUp();
}
