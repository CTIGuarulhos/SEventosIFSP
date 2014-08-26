<?php
include "../../initialize.php";
?>

/*********************************************************/
/**************** Variaveis globais **********************/
/*********************************************************/
var Dia, Mes, Ano, Hora, Minuto, Saida;
Dia = <?php echo $EVENTO['DIA_INICIO'] ?>;
Mes = <?php echo $EVENTO['MES'] ?>;
Ano = <?php echo $EVENTO['ANO'] ?>;
Hora = <?php echo $EVENTO['HORA'] ?>;	//19h = horário + 1
Minuto = <?php echo $EVENTO['MINUTO'] ?>;
Saida = 'contagem';



/************************************************************/
/** Funções a serem executadas após carregamento da página **/
/************************************************************/
$(document).ready(function() {

if ( !$.browser.msie ) {
//Adiciona efeito nos itens do menu superior
$("#menu ul li a").hover(
function() {
if ( !$(this).parent().hasClass("atual") )
$(this).corner("7px");
}, 
function() {
if ( !$(this).parent().hasClass("atual") )
$(this).uncorner();
}
);

//Cantos arredondados para (Brownser != IE)
$("#login form input").corner("3px");
}


//Adiciona efeito nos itens do #subMenu ul
$("#subMenu ul li a").hover(
function(){
$(this).animate({
paddingLeft: '24px'
}, 100, function(){ $(this).clearQueue(); });
},
function(){
$(this).animate({
paddingLeft: '16px'
}, 100, function(){ $(this).clearQueue(); });
}
);


//Adiciona a classe no último item do menu
$("#subMenu ul li:last").find("a").addClass("ultimo");


//Cantos arredondados
$("#corpo").corner("br bl 15px");
$("#banner").corner("tr tl 15px");
$("#rodape").corner("tr tl br bl 15px");
$("#pagina").corner("tr tl br bl 15px");    
$("#allrounded").corner("tr tl br bl 15px");


//Ajustes no layout para o IE7
if ( $.browser.msie && $.browser.version<=7 ) {
$("#rodape .informacoes").css("background-image", "none");
$("#menu").css("margin-top", "-3px");
$("#contagem").css("margin-top", "-18px");
$(".pessoas").css("margin-top", "-28px");
$(".arvores").css("margin-top", "-22px");
$(".geral").css("margin-top", "-25px");
$(".lagarto").css("margin-top", "-33px");
$(".apoio").append("&nbsp;");
$("#login form").append("&nbsp;");
$("#login form a").css("font-size", "9px");
}


//Efeito de login (tela escura)
$("#carregando").css("opacity", "0.7");
$("#carregando").ajaxStart(function(){ $(this).fadeIn(400); });
$("#carregando").ajaxStop(function(){ $(this).hide(); });


//Mensagens de erro e sucesso
$(".error-message").slideDown(500);
$(".success-message").slideDown(500);


//Efeito mostrar/esconder eventos
$("h1.evento-data").click(function(){
$(this).parent().find(".evento").slideToggle(500);
});

});



/*********************************************************/
/************ Função para contagem regressiva ************/
/*********************************************************/
function ContagemRegressiva()
{

var SS = '00'; //Segundos
var hoje = new Date(); //Dia
var futuro = new Date(Ano,Mes-1,Dia,Hora,Minuto,0); //Data limite do contador

var ss = parseInt((futuro - hoje) / 1000); //Determina a quantidade total de segundos que faltam
var mm = parseInt(ss / 60); //Determina a quantidade total de minutos que faltam
var hh = parseInt(mm / 60); //Determina a quantidade total de horas que faltam
var dd = parseInt(hh / 24); //Determina a quantidade total de dias que faltam

ss = ss - (mm * 60); //Determina a quantidade de segundos
mm = mm - (hh * 60); //Determina a quantidade de minutos
hh = hh - (dd * 24); //Determina a quantidade de horas

//O bloco abaixo descreve monta o que vai ser escrito na tela
var faltam = '';
//	faltam += 'Faltam apenas: ';
faltam += (dd && dd > 1) ? dd+' dias, ' : (dd==1 ? '1 dia, ' : '');
if (toString(hh).length)
faltam += (hh < 10) ? '0'+hh+':' : hh+':';
if (toString(mm).length)
faltam += (mm < 10) ? '0'+mm+':' : mm+':';
if (toString(ss).length)
faltam += (ss < 10) ? '0'+ss : ss;
//	faltam += ' para <?php echo $EVENTO['GENERO'] ?> <?php echo $EVENTO['NOME'] ?> ';
//	faltam += 'do <?php echo $EVENTO['NOME_INST_RED'] ?>:<br/>';

if (dd+hh+mm+ss > 0) {
document.getElementById(Saida).innerHTML = faltam;//INsere o conteudo da variável faltam na página.
setTimeout('ContagemRegressiva()',1000);//Reinicia a função a cada um segundo
} else {
document.getElementById(Saida).innerHTML = '';
setTimeout('ContagemRegressiva()',1000);
}
}



/*********************************************************/
/***** Função para abrir janela de reenvio de senha ******/
/*********************************************************/
function RecuperarSenha()
{
window.open("<?php echo $CONFIG->URL_ROOT ?>/esqueceu.php","esqueceu","width=375,height=320,top=0,resizable=no,menubar=no,scrollbars=no,status=no");
}