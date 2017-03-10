/**
 * Created by killswitch on 3/24/2015.
 */
getStacks($('#fs'),2);
getStacks($('#fu'),1);
function getStacks(el, type_id){
    $.getJSON('php/getstacks.php', {id : type_id}, function(data) {
        $.each(data, function(index, element) {
            if(type_id==2){
                el.append('<a href="'+element.stackname+'">'+element.stackname+'</a>');
            }else{
                el.append('<a href="stack.php?id='+element.stack_id+'">'+element.stackname+'</a>');
            }
        });
    });
}