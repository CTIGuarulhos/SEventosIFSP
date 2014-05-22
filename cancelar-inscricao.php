<?php

require "initialize.php";
$Return_URL = $CONFIG->URL_ROOT . "/?pag=meuseventos";


//Verifica se o usuário está logado
if (!$SESSION->IsLoggedIn()) {
    header('Location: ' . $CONFIG->URL_ROOT . '/?pag=cadastro');
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
    } else {
        $result = mysql_fetch_array($result);
        $dt = date_create($result['data']);         //datetime		
        $ts_evento = mktime(23, 59, 59, date_format($dt, "m"), date_format($dt, "d"), date_format($dt, "Y"));  //timestamp da data do evento
        //$ts_evento = $DATA_MAX; //Prazo máximo para inscrições
    }
}


//Verifica se nao passou o peróodo de inscrição
if ($dadosOK) {
    if (time() >= $ts_evento) {
        $erro = "Prazo de cancelamento encerrado para este evento.";
        $dadosOK = false;
    }
}

if ($dadosOK) {
    $query = "SELECT presenca FROM participacoes WHERE cpf_participante=";
    $query .= "'{$USER->getCpf()}' AND id_evento='$evento'";
    $presenca = $DB->Query($query);
    if (@mysql_num_rows($presenca) <= 0) {
        $erro = "Inscrição inexistente.";
        $dadosOK = false;
    } else {
        $presenca = mysql_fetch_array($presenca);

        if ($presenca['presenca'] == "1") {
            $erro = "Presença já confirmada.";
            $dadosOK = false;
        }
    }
}


if ($dadosOK) { //if 01
    $query = "DELETE FROM participacoes WHERE cpf_participante=";
    $query .= "'{$USER->getCpf()}' AND id_evento='$evento'";

    if ($DB->Query($query)) { //if 02
        $_SESSION['temp']['inscricaoOK'] = true;
        $_SESSION['temp']['inscricaoMSG'] = "Inscri&ccedil&atilde;o Cancelada com sucesso.<br/><br/>Agora voc&ecirc; pode " .
                "se inscrever em outro evento nesta mesma data e hora.";
    } else { //if 02
        $_SESSION['temp']['inscricaoOK'] = false;
        $_SESSION['temp']['inscricaoMSG'] = "Erro ao cancelar Inscri&ccedil&atilde;o.<br/><br/>Por favor, tente novamente. " .
                "Se o erro persistir avise-nos <a href=\"" . $CONFIG->URL_ROOT .
                "/contato.php\">clicando aqui</a>.";
    } //if 02
} else { //if 01
    $_SESSION['temp']['inscricaoOK'] = false;
    $_SESSION['temp']['inscricaoMSG'] = $erro;
} //if 01


header("Location: {$Return_URL}");
?>
