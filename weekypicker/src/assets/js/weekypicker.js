$(document).ready(function() {

    // Valida se o cronometro não esta totalmente vazio
    $('form').on('submit', function(){

        // Caso seja envio manual
        if ( $('#cron-manual').is(':checked') ) return true;

        var r = false;
        $('input.weekypicker').each(function(){
            if ($(this).val() != '[]' && $(this).val() != ''){
                r = true;
            }
        });
        if (!r) {
            $('html, body').animate({
                scrollTop: $("#tempo-de-execucao").offset().top
            }, 1000);
            setTimeout(function(){
                setInterval(function(){
                    $('span.label-danger').fadeToggle(500);
                },1500);
            },800);
        }
        return r;
    });

    // Botão manual/auto
    $(".weekypicker-manual").on('click', function(){
        $(".weekypicker-manual").each(function(){
           $(this).removeClass('btn-success');
        });
        $(this).addClass('btn-success');
        if ( $(this).data('type') == 'auto') {
            $('.weekypicker-cron').slideDown();
            $('#cron-manual').prop('checked',false);
        } else {
            $('.weekypicker-cron').slideUp();
            $('#cron-manual').prop('checked',true);
        }
    });

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
        clearInputs();
    });

    // Toggle button
    $(".weekypicker-select").on("click", function(){
        $(this).parent().parent().children('div.weekypicker-menu').slideToggle(1000);
    });

    // Marcar todos
    $(".weekypicker-all").on("click", function(){
        var e = $(this).parent().parent().children('div.weekypicker-menu').slideDown(1000);
        $.each($(this).parent().parent().children('div.weekypicker-menu').children('div'), function(element){
            $(this).removeClass('btn-success');
            $(this).trigger("click");
        });
    });

    // Desmarcar todos
    $(".weekypicker-none").on("click", function(){
        var e = $(this).parent().parent().children('div.weekypicker-menu').slideDown(1000);
        $.each($(this).parent().parent().children('div.weekypicker-menu').children('div'), function(element){
            $(this).addClass('btn-success');
            $(this).trigger("click");
        });
        clearInputs();
    });

    // Carrega os botões selecionados
    loadCron();
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
                // Atribui a classe em todas as div correspondentes
                $('div.weekypicker[data-type="' + type + '"][data-'+type+'="'+value+'"]').addClass("btn-success");
            });
        }
    });
    // Verifica o estado do manual/auto
    if ( $('#cron-manual').is(':checked') ) { $(".weekypicker-manual[data-type='manual']").trigger('click') };
}

function clearInputs() {
    $('input.weekypicker').each(function(){
        if ( $(this).val() == '[]') $(this).val("") ;
    });
}