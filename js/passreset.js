$("#inputPasswordConfirm").keyup(function(){
    if($('#inputPassword').val()==$('#inputPasswordConfirm').val()){
        $('#inputPasswordConfirm').css('box-shadow','0 0 8px rgba(92, 184, 92, 0.6)');
        $('#inputPasswordConfirm').css('border-color','rgb(92, 184, 92)');
    }else{
        $('#inputPasswordConfirm').css('box-shadow','0 0 8px rgba(217, 83, 79, 0.6)');
        $('#inputPasswordConfirm').css('border-color','rgb(217, 83, 79)');
    }
});
function checkMatch(){
    if($('#inputPassword').val()==$('#inputPasswordConfirm').val()){
        $('#inputPasswordConfirm').css('box-shadow','0 0 8px rgba(92, 184, 92, 0.6)');
        $('#inputPasswordConfirm').css('border-color','rgb(92, 184, 92)');
        return true;
    }else {
        $('#inputPasswordConfirm').css('box-shadow', '0 0 8px rgba(217, 83, 79, 0.6)');
        $('#inputPasswordConfirm').css('border-color', 'rgb(217, 83, 79)');
        return false;
    }
}
$("#passreset").on('submit', function(e){
    e.preventDefault();
    if(checkMatch()){
         $.ajax({
         type     : "POST",
         cache    : false,
         url      : '/php/changepassword.php',
         data     : $(this).serialize(),
         success  : function(data) {
             if(data=="3"){
                 $(".pass_retrieve").fadeOut("slow",function(){
                     $(".pass_retrieve").html("<h4>All Done!</h4><p>Your password has been updated</p>");
                     $(".pass_retrieve").fadeIn("slow");
                 })
             }else if(data=="2"){
                 $(".pass_retrieve").fadeOut("slow",function(){
                     $(".pass_retrieve").html("<a href='/index.php'><h4>Login In</h4></a><p>Your password has been updated</p>");
                     $(".pass_retrieve").fadeIn("slow");
                 })
             }else{
                alert("error: "+data);
             }
         },
         error: function(xhr, status, error) {
         alert(xhr.responseText);
         }
         })
    }
});