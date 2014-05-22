/*********************************************************/
/********** Erro de Pendencia de confirmação *************/
/*********************************************************/

$(document).ready(function() {

    var ErrorHtml;
    ErrorHtml = '<div id="ErrorLogin" class="caixaMensagem">';
    ErrorHtml += '	Conta pendente de confirmação.';
    ErrorHtml += '	<br/><br/>';
    ErrorHtml += '	<input type="button" value="FECHAR" id="ErrorLoginClose" />';
    ErrorHtml += '</div>';

    //Exibe a mensagem
    $("#carregando").prepend(ErrorHtml);
    $("#carregando").fadeIn(300);

    //Fecha a mensagem
    $("#ErrorLoginClose").click(function() {
        $("#carregando").fadeOut(200);
    });

});
