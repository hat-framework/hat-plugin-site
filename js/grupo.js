$('.loadconf').click(function(event){
    var classe = 'expandido';
    //previne o padrão do evento click
    event.preventDefault();

    //esconde os outros itens do menu
    var obj = $(this);
    $('.loadconf').each(function(){
        if($(this).attr('href') != obj.attr('href')){
            $(this).parent().parent().children('.formcontainer').slideUp('fast');
            $(this).html('Editar'); 
        }
    });

    //alterna a classe e o texto do link clicado
    $(this).parent().parent().children('.formcontainer').slideToggle('fast');
    if($(this).hasClass(classe)){$(this).html('Editar');}
    else{$(this).html('Fechar');}
    $(this).toggleClass(classe);
});

$('.restore').click(function(event){
    event.preventDefault();
    var url = $(this).attr('href');
    $.ajax({
        url: url,
        type: 'POST',
        dataType: 'json',
        success: function(json) {
            blockUI_unwait();
            if(typeof json.redirect != 'undefined') {
                window.location.href = json.redirect;
            }
            if(json.status == 1){
                if (typeof json.success != 'undefined' && json.success != '') blockUI_success(json.success);
                else if(typeof json.alert != 'undefined' && json.alert != '') blockUI_alert(json.alert);
                else blockUI_error('Operação concluída, mas sem resposta do servidor!');
            }else{
                if (typeof json.erro != 'undefined') blockUI_error(json.erro);
                else blockUI_error('Operação concluída, mas sem resposta do servidor!');
            }
        },
        error: function(erro){
            blockUI_unwait();
            blockUI_error("Erro na comunicação com o site");
        }
    });
});