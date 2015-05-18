$(document).ready(function() {
    //$(".weekypicker").each(function(){
    //
    //});

    $(".weekypicker").on("click", function(){
        // Alter the button status
        if ($(this).hasClass("btn-success") ) $(this).removeClass("btn-success");
        else $(this).addClass("btn-success");

        // Select all data by type selected
        $('[data-type="'+$(this).data('type')+'"]').each( function() {

            // Filter only success buttons
            if ($(this).hasClass('btn-success'))
            console.log($(this).data($(this).data('type').toLowerCase()));
        });

    });

    // Toggle button
    $(".weekypicker-select").on("click", function(){
        $(this).parent().parent().children('div.weekypicker-menu').slideToggle();
    });
});