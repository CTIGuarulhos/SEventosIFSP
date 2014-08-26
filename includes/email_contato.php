<?php

// no direct access
isset($CONFIG) or exit('Acesso Restrito');

/**
 * Desenvolvido para o sistema da semana de ci�ncia e tecnologia do IFSP 
 * 
 * 
 * @param $nome    = Nome do usu�rio a ser enviado o email
 * @param $email   = endere�o de email do usu�rio 
 * @param $assunto = Assunto da msg
 * @param $msg     = Mensagem
 * @param $para    = endere�o de email para quem ser� enviada a msg 
 *  
 * @return TRUE se enviado com sucesso. Sen�o retorna FALSE. 
 */
function email_contato($nome, $email, $assunto, $msg, $para = false) {

    global $CONFIG, $EVENTO;

    if ($para === false) {
        //Email padra, se nenhum for passado, assume este
        $para = "$CONFIG->CONTATO_EMAIL";
    }

    $PARA = $para;
    $ASSUNTO = remover_acentos("CONTATO - " . $EVENTO['NOME']);
    $RESPONDER_PARA = $email;

    $MSG = "<b>NOME:</b> $nome<br/><br/>\n";
    $MSG .= "<b>EMAIL:</b> $email<br/><br/>\n";
    $MSG .= "<b>ASSUNTO:</b> $assunto<br/><br/>\n";
    $MSG .= "<b>MENSAGEM:</b><br/>\n";
    $MSG .= "<p>" . nl2br($msg) . "</p><br/>\n";
    $MSG .= $EVENTO['NOME'] . ".<br/>\n";
    /* 	$MSG .= "$EVENTO['NOME_INST_COMP']."; */

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

        if (@enviar_email($PARA, $ASSUNTO, $MSG, $RESPONDER_PARA))
            return true;
        else
            return false;
    }
}

?>
