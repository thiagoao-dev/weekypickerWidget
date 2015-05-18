$(document).ready(function() {

    // Carrega os botões selecionados
    loadCron();

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

        // Set the values to the input
        $('input.'+$(this).data('type')).val(JSON.stringify(objJson));

    });

    // Toggle button
    $(".weekypicker-select").on("click", function(){
        $(this).parent().parent().children('div.weekypicker-menu').slideToggle();
    });
});

function loadCron(){
    // Verifica em todas instancias de input
    $("input.weekypicker").each(function(){
        // Verifica se existe algum valor na instancia
        if ( $(this).val() ) {
            // Recupera o tipo do elemento e valores
            var type = $(this).attr('class').split(" ")[1];
            var data = $.parseJSON($(this).val());
            $.each(data, function(key, value){
                // Atribui a classe em todas as div correspondetes
                $('div.weekypicker[data-type="' + type + '"][data-'+type+'="'+value+'"]').addClass("btn-success");
            });
        }
    });
};