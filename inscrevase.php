<?php

require "initialize.php";
$returnURL = $CONFIG->URL_ROOT . "/?pag=programacao";
if (isset($_GET['SCT'])) {
    $returnURL .= "&SCT=" . $_GET['SCT'];
}


//Verifica se o usu�rio est� logado
if (!$SESSION->IsLoggedIn()) {
    header('Location: ' . $CONFIG->URL_ROOT . '/?pag=cadastro');
    exit;
}


$evento = safe_sql($_REQUEST['evento']); //id do evento
$dadosOK = true; //indica se os dados estão certos
//Verifica se o evento existe
if ($dadosOK) {
    $query = "SELECT * FROM eventos WHERE id='$evento' AND semtec='" . $SCT_ID . "'";
    $result = $DB->Query($query);
    if (@mysql_num_rows($result) <= 0) {
        $erro = "Evento inexistente.";
        $dadosOK = false;
    }
}


//Verifica se ha vagas e se nao passou o periodo de inscrição
if ($dadosOK) {
    $result = @mysql_fetch_array($result);
    $query = "SELECT * FROM participacoes WHERE id_evento='$evento'";
    $inscritos = @mysql_num_rows($DB->Query($query));
    $total_vagas = $result['vagas'];
    $dt = date_create($result['data']); //datetime (data apenas) do evento
    $horario = explode(":", $result['hora']); //horario do evento
    $ts = mktime($horario[0], $horario[1], 0, date_format($dt, "m"), date_format($dt, "d"), date_format($dt, "Y"));  //timestamp	
    $ts_evento = mktime(23, 59, 59, date_format($dt, "m"), date_format($dt, "d"), date_format($dt, "Y"));  //timestamp da data do evento
    //$ts_evento = $DATA_MAX; //Prazo m�ximo para inscrições
    if ($inscritos >= $total_vagas || time() >= $ts_evento) {
        $erro = "Vagas esgotadas ou prazo de Inscri&ccedil&atilde;o encerrado para este evento.";
        $dadosOK = false;
    }
}


//Verifica se j� est� inscrito no mesmo evento
if ($dadosOK) {
    $query = "SELECT * FROM participacoes WHERE id_evento='$evento' AND cpf_participante='{$USER->getCpf()}'";
    if (@mysql_num_rows($DB->Query($query)) > 0) {
        $erro = "Voc&ecirc; j&aacute; est&aacute; inscrito neste evento.";
        $dadosOK = false;
    }
}


//Verifica se o usu�rio j� est� inscrito em outro evento no mesmo hor�rio
if ($dadosOK) {
//	if($result['tipo'] == 2) 
//	{
//			$query = "SELECT id_evento FROM participacoes P WHERE P.cpf_participante='{$USER->getCpf()}' AND P.id_evento IN (SELECT id FROM eventos WHERE data='".date('Y-m-d',$ts)."')";
//			if(@mysql_num_rows($DB->Query($query))) 
//			{
//		    $erro = "Inscri&ccedil&atilde;o n&atilde;o realizada.<br/><br/>".
//		    		"Voc&ecirc; j&aacute est&aacute inscrito em outro evento que coincide ".
//		    		"no mesmo dia e hor&aacute;rio deste. Para prosseguir voc&ecirc; poder&aacute ".
//		    		"cancelar Inscri&ccedil&atilde;o no menu <b>meus eventos</b>.";
//		    $dadosOK = false;
//			}
//	} 
//	else 
//	{
    //$query = "SELECT id_evento FROM participacoes P WHERE P.cpf_participante='{$USER->getCpf()}' AND P.id_evento IN (SELECT id FROM eventos WHERE data='" . date('Y-m-d', $ts) . "' AND ((hora='" . date('H:i:s', $ts) . "' AND tipo<>'2') OR (hora='19:00:00' AND tipo='2')))";
    $query = "SELECT id_evento FROM participacoes P WHERE P.cpf_participante='{$USER->getCpf()}' AND P.id_evento IN (SELECT id FROM eventos WHERE data='" . date('Y-m-d', $ts) . "' AND ((hora='" . date('H:i:s', $ts) . "')))";
    if (@mysql_num_rows($DB->Query($query))) {
        $erro = "Inscri&ccedil&atilde;o n&atilde;o realizada.<br/><br/>" .
                "Voc&ecirc; j&aacute; est&aacute; inscrito em outro evento que coincide " .
                "no mesmo dia e hor&aacute;rio deste. Para prosseguir voc&eacute; poder&aacute; " .
                "cancelar inscri&ccedil&eth;es no menu <b>meus eventos</b>.";
        $dadosOK = false;
    }
//	}
}


//---------------------------------------------------------------------//


if ($dadosOK) { //if 01
    $query = "INSERT INTO participacoes VALUES('{$USER->getCpf()}','P',";
    $query .= "'$evento',Now(),'0',NULL,NULL)";

    if ($DB->Query($query)) { //if 02
        $_SESSION['temp']['inscricaoOK'] = true;
        $_SESSION['temp']['inscricaoMSG'] = "Inscri&ccedil&atilde;o Realizada com sucesso.<br/><br/>Para emiss&atilde;o do certificado " .
                "&eacute; necess&aacute;rio confirmar sua presen&ccedil;a no local e hor&aacute;rio do evento.";
    } else { //if 02
        $_SESSION['temp']['inscricaoOK'] = false;
        $_SESSION['temp']['inscricaoMSG'] = "Erro ao realizar inscri&ccedil&atilde;o.<br/><br/>Por favor, tente novamente. " .
                "Se o erro persistir avise-nos <a href=\"" . $CONFIG->URL_ROOT .
                "/?pag=contato\">clicando aqui</a>.";
    } //if 02
} else { //if 01
    $_SESSION['temp']['inscricaoOK'] = false;
    $_SESSION['temp']['inscricaoMSG'] = $erro;
} //if 01


header("Location: {$returnURL}");
?>