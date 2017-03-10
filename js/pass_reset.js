/**
 * Created by killswitch on 4/12/2015.
 */
$("#pass-reset").on('submit', function(e){
    e.preventDefault();
    $('#revbutton').html("Retrieving Password...Give it a moment");
    $.ajax({
        type     : "POST",
        cache    : false,
        url      : '/php/passreset.php',
        data     : $(this).serialize(),
        success  : function(data) {
            if(data == "3"){
                $(".pass_retrieve").fadeOut("slow",function(){
                    $(".pass_retrieve").html("<h4>Reset Sent! Check your email</h4><p>Don't forget to look in your spam/junk folder</p>");
                    $(".pass_retrieve").fadeIn("slow");
                })
            }else{
                $("#message").css("color","#FF4136");
                if(data == "2"){
                    $("#message").html("That Email doesn't seem to exist here");
                }else if(data == "4"){
                    $("#message").html("Wrong Captcha, try again!");
                }else{
                    alert("error: "+data);
                }
            }
            $('#revbutton').html("Retrieve password");
        },
        error: function(xhr, status, error) {
            alert("error: "+xhr.responseText);
            $('#revbutton').html("Retrieve password");
        }
    });
});
