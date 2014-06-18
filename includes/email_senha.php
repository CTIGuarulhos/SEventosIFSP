<?php

// no direct access
isset($CONFIG) or exit('Acesso Restrito');

/**
 * Desenvolvido para o sistema da semana de ci�ncia e tecnologia do IFSP 
 * 
 * 
 * @param $nome   = Nome do usu�rio a ser enviado o email
 * @param $senha  = Senha escolhida pelo usu�rio
 * @param $codigo = C�digo de confirma��o a ser enviado por e-mail
 * @param $email  = endere�o de email do usu�rio 
 *  
 * @return TRUE se enviado com sucesso. Sen�o retorna FALSE. 
 */
function email_senha($nome, $novasenha, $email, $codigo, $confirmado) {

    global $CONFIG, $EVENTO;

    $ASSUNTO = remover_acentos("NOVA SENHA");
    $PARA = $email;

    $MSG = "Olá $nome,<br/><br/>\n";
    if ($confirmado == 1) {
        $MSG .= 'Você está recebendo esta mensagem porque solicitou uma nova senha de acesso ao sistema d' . $EVENTO['GENERO'] . ' ' . $EVENTO['NOME'] . '.<br/>'; /* do $EVENTO['NOME_INST_RED'].<br/>\n"; */
        $MSG .= "Nova senha: <b>$novasenha</b><br/><br/>\n";
        $MSG .= "A senha poderá ser alterada após fazer o login no site, no menu \"meus dados\".<br/><br/>\n";
    }

    if ($confirmado == 0) {
        $MSG .= "Clique no link abaixo para ativar sua conta e poder se inscrever nos eventos oferecidos:<br/><br/>\n";
        $MSG .= '<a href="' . $CONFIG->URL_ROOT . '/?pag=confirmacao&codigo=' . $codigo . '">' . $CONFIG->URL_ROOT . '/?pag=confirmacao&codigo=' . $codigo . '</a>.<br/><br/>' . "\n";
        $MSG .= "Após ativação faça login no <a href=\"" . $CONFIG->URL_ROOT . "\">site</a> e escolha quais eventos deseja participar.<br/>\n";
        $MSG .= "Utilize seu e-mail e senha:<br/>\n";
        $MSG .= "E-mail: $email<br/>\n";
        $MSG .= "Nova Senha: $novasenha<br/><br/>\n";
    }
    $MSG .= "<b>Obs.:</b> Mensagem enviada automaticamente, favor não responder.<br/><br/>\n";
    $MSG .= '<a href="' . $CONFIG->URL_ROOT . '">' . $EVENTO['NOME'] . '</a><br/>' . "\n";
    /*  $MSG .= "$EVENTO['NOME_INST_COMP']."; */


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
