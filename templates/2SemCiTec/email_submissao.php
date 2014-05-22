<?php

// no direct access
/* isset($CONFIG) or exit( 'Acesso Restrito' ); */
function email_submissao($nome, $d_email, $emaileixo, $tipo, $nomes, $nome_temp, $tamanho, $periodo) {
    global $CONFIG, $EVENTO;
    $codigo = str_shuffle(date('dmYHis'));
    $nomearquivo = $codigo . ".pdf";
    move_uploaded_file($nome_temp, "/tmp/" . $nomearquivo); //Move o arquivo temporário
    require_once($CONFIG->DIR_ROOT . "/includes/phpmailer/class.phpmailer.php");
    //require($CONFIG->DIR_ROOT . "/templates/" . $EVENTO['TEMPLATE'] . "/nodb_functions.php");
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
    if ($emaileixo == "CIINED") {
        //$mail->AddBCC('douglasanpa@gmail.com');
        $mail->AddBCC('marinilzes@gmail.com');
        $mail->AddBCC('rogeriomarques@me.com');
    }
    if ($emaileixo == "CIINSA") {
        //$mail->AddBCC('douglasanpa@gmail.com');
        $mail->AddBCC('marinilzes@gmail.com');
        $mail->AddBCC('rogeriomarques@me.com');
    }
    if ($emaileixo == "CIINES") {
        //$mail->AddBCC('douglasanpa@gmail.com');
        $mail->AddBCC('marinilzes@gmail.com');
        $mail->AddBCC('rogeriomarques@me.com');
    }
    if ($emaileixo == "PRLOSU") {
        //$mail->AddBCC('douglasanpa@gmail.com');
        $mail->AddBCC('marinilzes@gmail.com');
        $mail->AddBCC('rogeriomarques@me.com');
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
        $mail->AddAttachment("/tmp/" . $nomearquivo);
    }
    $mensagem .= "<br/>\n";
    $mensagem .= "<br/>\n";
    if ($emaileixo == "CIINED") {
        $mensagem .= "<b>Eixo:</b> Ciência, Inovação e Educação\n<br>";
    }
    if ($emaileixo == "CIINSA") {
        $mensagem .= "<b>Eixo:</b> Ciência e Inovação em Saúde\n<br>";
    }
    if ($emaileixo == "CIINES") {
        $mensagem .= "<b>Eixo:</b> Ciência e Inovação em Esporte\n<br>";
    }
    if ($emaileixo == "PRLOSU") {
        $mensagem .= "<b>Eixo:</b> Práticas Locais Sustentáveis\n<br>";
    }
    if ($emaileixo == "TEST") {
        $mensagem .= "<b>Eixo:</b> TESTE DE ENVIO\n<br>";
    }
    if ($tipo == "Poster") {
        $mensagem .= "<b>Tipo:</b> Pôster\n<br>";
    }
    if ($tipo == "Oral") {
        $mensagem .= "<b>Tipo:</b> Comunicação Oral\n<br>";
    }
    $mensagem .= "<b>Código:</b> " . $codigo . "\n<br>";
    $mensagem .= "<b>Nome:</b> " . $nome . "\n<br>";
    $mensagem .= "<b>E-mail:</b> " . $d_email . "\n<br>";
    $mensagem .= "<b>Disponibilidade:</b> " . $periodo . "\n<br>";
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
        $row['id'] = "";
        $row['eixo'] = $emaileixo;
        $row['tipo'] = $tipo;
        $row['nome'] = $nome;
        $row['email'] = $d_email;
        $row['codigo'] = $codigo;
        $row['arquivo'] = $nomearquivo;
        $row['periodo'] = $periodo;
        insertRow($row, "submissao.nodb", "submissao", $CONFIG->DIR_ROOT . "/templates/" . $EVENTO['TEMPLATE'] . "/db");
        return true;
    }
    unlink("/tmp/" . $nomearquivo);
}

?>
