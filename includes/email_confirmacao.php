<?php

// no direct access
isset($CONFIG) or exit('Acesso Restrito');

/**
 * Desenvolvido para o sistema da semana de ciência e tecnologia do IFSP 
 * 
 * 
 * @param $nome   = Nome do usuario a ser enviado o email
 * @param $senha  = Senha escolhida pelo usuario
 * @param $codigo = Código de confirmação a ser enviado por e-mail
 * @param $email  = endere�o de email do usu�rio 
 *  
 * @return TRUE se enviado com sucesso. Senão retorna FALSE. 
 */
function email_confirmacao($nome, $senha, $codigo, $email) {

    global $CONFIG, $EVENTO;

    if ($para === false) {
        //Email padra, se nenhum for passado, assume este
        $para = "$CONFIG->CONTATO_EMAIL";
    }

    $ASSUNTO = remover_acentos("CONFIRMAÇÃO DE CADASTRO");
    $PARA = $email;

    $MSG = "Olá $nome,<br/><br/>\n";
    $MSG .= 'Você está recebendo esta mensagem porque se cadastrou na ' . $EVENTO['NOME'] . '.<br/>'; /* ' do '.$EVENTO['NOME_INST_RED'].'.<br/>'; */

    $MSG .= "Clique no link abaixo para ativar sua conta e poder se inscrever nos eventos oferecidos:<br/><br/>\n";
    $MSG .= '<a href="' . $CONFIG->URL_ROOT . '?pag=confirmacao&codigo=' . $codigo . '">' . $CONFIG->URL_ROOT . '/?pag=confirmacao&codigo=' . $codigo . '</a>.<br/><br/>' . "\n";
    $MSG .= "Após ativação faça login no <a href=\"" . $CONFIG->URL_ROOT . "\">site</a> e escolha quais eventos deseja participar.<br/>\n";
    $MSG .= "Utilize seu e-mail e senha:<br/>\n";
    $MSG .= "E-Mail: $email<br/>\n";
    $MSG .= "Senha: $senha<br/><br/>\n";
    $MSG .= "<b>Obs.:</b> Mensagem enviada automaticamente, favor não responder.<br/>\n";
    $MSG .= "Caso você não tenha se inscrito neste site favor desconsiderar esta mensagem.<br/><br/>\n";
    $MSG .= $EVENTO['NOME'] . '.<br/>';

    /* 	$MSG .= $EVENTO['NOME_INST_COMP'].'.'; */


    /*     * ********************* FUNÇÃO MAIL DO PHP ****************************** */
    $to = $PARA;
    $subject = $ASSUNTO;
    $message = $MSG;
    $headers = remover_acentos($EVENTO['NOME']) . ' <' . $CONFIG->MAIL_FROM . '>' . "\r\n" .
            'Reply-To: ' . $email . "\r\n";
    $headers .= "Content-Type: text/html; charset=\"utf-8\"\r\n";
    /*     * ************************************************************************ */

    if ($CONFIG->USE_SENDMAIL) {

        if (@mail($to, $subject, $message, $headers))
            return true;
        else
            return false;
    } else {

        require_once($CONFIG->DIR_ROOT . "/includes/phpmailer/enviar.php");

        if (@enviar_email($PARA, $ASSUNTO, $MSG))
            return true;
        else
            return false;
    }
}

function email_reconfirmacao($nome, $codigo, $email) {

    global $CONFIG, $EVENTO;

    if ($para === false) {
        //Email padra, se nenhum for passado, assume este
        $para = "$CONFIG->CONTATO_EMAIL";
    }

    $ASSUNTO = remover_acentos("CONFIRMAÇÃO DE CADASTRO");
    $PARA = $email;

    $MSG = "Olá $nome,<br/><br/>\n";
    $MSG .= 'Você está recebendo esta mensagem porque se cadastrou na ' . $EVENTO['NOME'] . '.<br/>'; /* ' do '.$EVENTO['NOME_INST_RED'].'.<br/>'; */

    $MSG .= "Clique no link abaixo para ativar sua conta e poder se inscrever nos eventos oferecidos:<br/><br/>\n";
    $MSG .= '<a href="' . $CONFIG->URL_ROOT . '/?pag=confirmacao&codigo=' . $codigo . '">' . $CONFIG->URL_ROOT . '/?pag=confirmacao&codigo=' . $codigo . '</a>.<br/><br/>' . "\n";
    $MSG .= "Após ativação faça login no <a href=\"" . $CONFIG->URL_ROOT . "\">site</a> e escolha quais eventos deseja participar.<br/>\n";
    $MSG .= "Utilize seu e-mail e senha:<br/><br/><br/>\n\n\n";
    $MSG .= "<b>Obs.:</b> Mensagem enviada automaticamente, favor não responder.<br/>\n";
    $MSG .= "Caso você não tenha se inscrito neste site favor desconsiderar esta mensagem.<br/><br/>\n";
    $MSG .= $EVENTO['NOME'] . '.<br/>';

    /* 	$MSG .= $EVENTO['NOME_INST_COMP'].'.'; */


    /*     * ********************* FUNÇÃO MAIL DO PHP ****************************** */
    $to = $PARA;
    $subject = $ASSUNTO;
    $message = $MSG;
    $headers = remover_acentos($EVENTO['NOME']) . ' <' . $CONFIG->MAIL_FROM . '>' . "\r\n" .
            'Reply-To: ' . $email . "\r\n";
    $headers .= "Content-Type: text/html; charset=\"utf-8\"\r\n";
    /*     * ************************************************************************ */

    if ($CONFIG->USE_SENDMAIL) {

        if (@mail($to, $subject, $message, $headers))
            return true;
        else
            return false;
    } else {

        require_once($CONFIG->DIR_ROOT . "/includes/phpmailer/enviar.php");

        if (@enviar_email($PARA, $ASSUNTO, $MSG))
            return true;
        else
            return false;
    }
}

?>
