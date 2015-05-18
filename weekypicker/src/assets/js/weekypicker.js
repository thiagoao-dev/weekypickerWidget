$(document).ready(function() {
    $(".weekypicker").each(function(){
    });

    $(".weekypicker").on("click", function(){
        if ($(this).hasClass("btn-success") ) $(this).removeClass("btn-success");
        else $(this).addClass("btn-success");
    });
});