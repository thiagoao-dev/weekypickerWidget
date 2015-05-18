$(document).ready(function() {
    // Catch clicked button
    $(".weekypicker").on("click", function(){
        // Alter the button status
        if ($(this).hasClass("btn-success") ) $(this).removeClass("btn-success");
        else $(this).addClass("btn-success");

        var objJson = [];
        var counter = 0;
        // Select all data by type selected
        $('[data-type="'+$(this).data('type')+'"]').each( function() {

            // Filter only success buttons
            if ($(this).hasClass('btn-success')) {
                objJson[counter] = $(this).data($(this).data('type').toLowerCase());
                counter++;
            }
        });

        console.log(objJson);
        $('input.'+$(this).data('type')).val(JSON.stringify(objJson));

    });

    // Toggle button
    $(".weekypicker-select").on("click", function(){
        $(this).parent().parent().children('div.weekypicker-menu').slideToggle();
    });
});