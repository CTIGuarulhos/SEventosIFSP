$().ready(function() {
    $("#tabs").tabs({
        event: "mouseover"
    });
    $("#nome").focus();
    $("#frmCadastro").buttonset();
    $("#divImprimir").buttonset();
    $("#frmLimpar").buttonset();
    $("input:submit,input:text,input:checkbox, select, a, button", ".demo").button();
});


$(function() {
    $("#frmCadastro").validate({
        rules: {
            "nome": {
                required: true,
                maxlength: 32,
                minlength: 3
            },
            "instituicao": {
                required: true
            },
            "tipoParticipante": {
                required: true
            }
        },
        messages: {
            "nome": "NOME: obrigatório, máximo 32 carácteres, pode ser abreviado",
            "instituicao": "INSTITUIÇÃO: obrigatória",
            "tipoParticipante": "TIPO PARTICIPANTE: obrigatório"
        }
    });

});

/*
 function imprimir(){
 //$("#divCracha").printElement();
 $("#btnImprimir").css("display","none");
 $("#frmCadastro").css("display","none");
 window.print();
 }
 */
/*
 function imprimir(){
 $("#divCracha").printElement({
 printMode:'popup'
 });    
 }
 */

function imprimir() {
    $("#divCracha").printElement({
        overrideElementCSS: [
            'cracha.css',
            {
                href: 'cracha.css',
                media: 'print'
            }]
    });
}




