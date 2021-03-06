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
                parent.siblings(".count").html(votes+2);
                x.removeClass('stack-down');
                parent.addClass('stack-up');
            }else{
                parent.siblings(".count").html(votes+1);
                parent.addClass('stack-up');
            }
        }
        $.ajax({
            type: "POST",
            url: "../php/stackup.php",
            data: dataString,
            cache: false,

            success: function(data){
            }
        });
    }else{
        if(parent.hasClass('stack-down')){
            parent.removeClass('stack-down');
            parent.siblings(".count").html(votes+1);
        }else{
            var x = parent.siblings(".stackup");
            if(x.hasClass('stack-up')){
                parent.siblings(".count").html(votes-2);
                x.removeClass('stack-up');
                parent.addClass('stack-down');
            }else{
                parent.siblings(".count").html(votes-1);
                parent.addClass('stack-down');
            }
        }
        $.ajax({
            type: "POST",
            url: "../php/stackdown.php",
            data: dataString,
            cache: false,

            success: function(html)
            {
            }
        });
    }
    return false;
});