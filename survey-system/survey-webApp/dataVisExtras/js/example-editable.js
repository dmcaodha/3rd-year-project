
//make table editable, refresh charts on blur$(function(){
$(function(){
    $('table').visualize({
        type: 'pie', 
        height: '300px', 
        width: '450px'
    });

    $('table td')
		
    .hover(function(){
        $(this).addClass('hover');
    },function(){
        $(this).removeClass('hover');
    });
});