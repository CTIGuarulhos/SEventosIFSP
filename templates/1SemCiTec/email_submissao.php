<?php

// no direct access
/* isset($CONFIG) or exit( 'Acesso Restrito' ); */
function email_submissao($nome, $d_email, $emaileixo, $nomes, $nome_temp, $tamanho) {
    global $CONFIG, $EVENTO;
    move_uploaded_file($nome_temp, "/tmp/" . $nomes); //Move o arquivo temporário
    require_once($CONFIG->DIR_ROOT . "/includes/phpmailer/class.phpmailer.php");
    date_default_timezone_set('America/Sao_Paulo'); // Caso queira ter data no email
    $mail = new PHPMailer();
    $mail->IsSMTP(); // Send via SMTP
    $mail->Host = $CONFIG->MAIL_SMTP; // Seu servidor SMTP
    $mail->Port = "465";
    $mail->SMTPSecure = "ssl";
    $mail->SMTPAuth = $CONFIG->MAIL_AUTH; // 'true' para autenticação
    $mail->Username = $CONFIG->MAIL_USER; // Usuário de SMTP
    $mail->Password = $CONFIG->MAIL_PSWD; // Senha de SMTP
    $mail->From = $CONFIG->MAIL_FROM;
    $mail->FromName = $CONFIG->MAIL_NAME;
    if ($emaileixo == "FDEB") {
        $mail->AddBCC('bueno_elaine@yahoo.com.br');
        $mail->AddBCC('coordenacaosemcitec@gmail.com');
    }
    if ($emaileixo == "SDES") {
        $mail->AddBCC('bueno_elaine@yahoo.com.br');
        $mail->AddBCC('coordenacaosemcitec@gmail.com');
    }
    if ($emaileixo == "PSDL") {
        $mail->AddBCC('bueno_elaine@yahoo.com.br');
        $mail->AddBCC('coordenacaosemcitec@gmail.com');
    }
    if ($emaileixo == "INTE") {
        $mail->AddBCC('bueno_elaine@yahoo.com.br');
        $mail->AddBCC('coordenacaosemcitec@gmail.com');
    }

    if ($emaileixo == "TEST") {
        $mail->AddBCC('douglasanpa@gmail.com');
    }
    $mail->AddReplyTo($d_email, $nome);
    $mail->AddAddress($d_email);
    ini_set('max_execution_time', '2000');
    ini_set("memory_limit", "50M");
    $mail->WordWrap = 20;
    if ($nomes != "") {
        $mail->AddAttachment("/tmp/" . $nomes);
    }
    $mensagem .= "<br/>\n";
    $mensagem .= "<br/>\n";
    if ($emaileixo == "FDEB") {
        $mensagem .= "<b>Eixo:</b> Formação Docente para a Educação Básica\n<br>";
    }
    if ($emaileixo == "SDES") {
        $mensagem .= "<b>Eixo:</b> Sustentabilidade e Desenvolvimento Econômico e Social\n<br>";
    }
    if ($emaileixo == "PSDL") {
        $mensagem .= "<b>Eixo:</b> Práticas Sustentáveis e desenvolvimento local\n<br>";
    }
    if ($emaileixo == "INTE") {
        $mensagem .= "<b>Eixo:</b> Inovação Tecnológica\n<br>";
    }

    if ($emaileixo == "TEST") {
        $mensagem .= "<b>Eixo:</b> TESTE DE ENVIO\n<br>";
    }

    $mensagem .= "<b>Nome:</b> " . $nome . "\n<br>";
    $mensagem .= "<b>E-mail:</b> " . $d_email . "\n<br>";
    $mensagem .= "<br/>\n";
    $mensagem .= "Esta Mensagem foi enviada Automaticamente, favor não responder\n";
    $mensagem .= "<br/>\n";
    $mensagem .= "O usuário e o responsável pelas submissões receberam este e-mail\n";
    $mensagem .= "<br/>\n";
    $mensagem .= "<br/>\n";
    $mensagem .= $EVENTO['NOME'] . ".<br/>\n";
    /* 	$mensagem .= "$EVENTO['NOME_INST_COMP']."; */
    $assunto = "[SUBMISSÃO DE TRABALHOS - " . $emaileixo . "] - " . $nome;
    $mail->IsHTML(true);
    $mail->Subject = "$assunto";
    $mail->Body = "<b>" . $assunto . "</b><br />" . $mensagem;
    $mail->AltBody = "Para mensagens somente texto";
    if (!$mail->Send()) {
        return false;
    } else {
        return true;
    }
    unlink("/tmp/" . $nomes);
}

?>
