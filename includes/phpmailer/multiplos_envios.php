<?php

// no direct access
defined('URL_ROOT') or exit('Acesso Restrito');

function enviar_multiplos_emails($email_array, $assunto, $msg, $responder_para = false) {
    require_once("class.phpmailer.php");
//instancia a objetos
    $mail = new PHPMailer();
// mandar via SMTP
    $mail->IsSMTP();
// Seu servidor smtp
    $mail->Host = MAIL_SMTP;
// Mantem conexao aberta
    $mail->SMTPKeepAlive = true;
// habilita smtp autenticado
    $mail->SMTPAuth = MAIL_AUTH;
// usurio deste servidor smtp
    $mail->Username = MAIL_USER;
    $mail->Password = MAIL_PSWD;
//email utilizado para o envio
//pode ser o mesmo de username
    $mail->From = MAIL_EMAIL;
    $mail->FromName = MAIL_NOME;
//wrap seta o tamanhdo do texto por linha
    $mail->WordWrap = 50;
//anexando arquivos no email
//  $mail->AddAttachment("arquivo.rar");
//  $mail->AddAttachment("imagem.gif");
    $mail->IsHTML(true); //enviar em HTML
// informando a quem devemos responder
//ou seja para o mail inserido no formulario
    $reply = $responder_para === false ? MAIL_EMAIL : $responder_para;
    $mail->AddReplyTo("$reply", "$reply");
    $mail->Subject = $assunto;
//adicionando o html no corpo do email
    $mail->Body = $msg;

//Início dos envios
//$time1 = date('H:i:s');
//Envia as mensagens uma a uma para os destinatários em $email_array
    foreach ($email_array as $destinatario):

        //Verifica se o email não é vazio (NULL)
        if (!is_null($destinatario['email']) && !empty($destinatario['email'])) {
            $mail->AddBCC($destinatario['email'], $destinatario['nome']);
        }

    endforeach;

//Tenta enviar a mensagem
    $ok = @$mail->Send();

//Fim dos envios
//$time2 = date('H:i:s');
//$return_array[] = array("INICIO"=>$time1, "FIM"=>$time2);
//Retorna o array com os resultados dos envios
    if ($ok) {
        return true;
    } else {
        return false;
    }
}

?>