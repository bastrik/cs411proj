$(document).on('click', '.cbutton', function(){
    var id = $(this).closest('.comment').data("commentid");
    var name = $(this).attr("name");
    var dataString = 'id='+ id ;
    var parent = $(this);
    var count = $(this).siblings('.score');
    var votes = parseInt(count.html());
    if (name=='up') {
        if(parent.hasClass('stack-up')){
            count.html(votes-1);
            parent.removeClass('stack-up');
        }else{
            var x = parent.siblings(".stackdown");
            if(x.hasClass('stack-down')){
                count.html(votes+2);
                x.removeClass('stack-down');
                parent.addClass('stack-up');
            }else{
                count.html(votes+1);
                parent.addClass('stack-up');
            }
        }
        $.ajax({
            type: "POST",
            url: "/php/poststackup.php",
            data: dataString,
            cache: false,

            success: function(data){
            }
        });
    }else{
        if(parent.hasClass('stack-down')){
            parent.removeClass('stack-down');
            count.html(votes+1);
        }else{
            var x = parent.siblings(".stackup");
            if(x.hasClass('stack-up')){
                count.html(votes-2);
                x.removeClass('stack-up');
                parent.addClass('stack-down');
            }else{
                count.html(votes-1);
                parent.addClass('stack-down');
            }
        }
        $.ajax({
            type: "POST",
            url: "/php/poststackdown.php",
            data: dataString,
            cache: false,

            success: function(data){
            }
        });
    }
    return false;
});