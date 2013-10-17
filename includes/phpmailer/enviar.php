<?php

// no direct access
isset($CONFIG) or exit('Acesso Restrito');

function enviar_email($para, $assunto, $msg, $responder_para = false) {

    global $CONFIG, $EVENTO;

    require_once("class.phpmailer.php");
//instancia a objetos
    $mail = new PHPMailer();
// mandar via SMTP
    $mail->IsSMTP();
// Seu servidor smtp
    $mail->Host = $CONFIG->MAIL_SMTP;
//Porta do servidor SMPT
    $mail->Port = "465";
// habilita smtp autenticado
    $mail->SMTPAuth = $CONFIG->MAIL_AUTH;
// usurio deste servidor smtp
    $mail->SMTPSecure = "ssl";
//tipo de conxao segura

    /*
      $mail->Username = "cadastro@ifsaocarlos.net";
      $mail->Password = "8HRYUD9D"; // senha
     */

    $mail->Username = $CONFIG->MAIL_USER;
    $mail->Password = $CONFIG->MAIL_PSWD; // senha
//email utilizado para o envio
//pode ser o mesmo de username
    $mail->From = $CONFIG->MAIL_FROM;
    $mail->FromName = $CONFIG->MAIL_NAME;
//Endereco que deve ser enviada a mensagem
    if (is_array($para)) {
        foreach ($para as &$emailarray) {
            $mail->AddAddress($emailarray, $emailarray);
        }
    } else {
        $mail->AddAddress($para, $para);
    }
//wrap seta o tamanhdo do texto por linha
    $mail->WordWrap = 50;
//anexando arquivos no email
//  $mail->AddAttachment("arquivo.rar");
//  $mail->AddAttachment("imagem.gif");
    $mail->IsHTML(true); //enviar em HTML
// informando a quem devemos responder
//ou seja para o mail inserido no formulario
    $reply = $responder_para === false ? $CONFIG->MAIL_FROM : $responder_para;
    $mail->AddReplyTo("$reply", "$reply");
    $mail->Subject = $assunto;
//adicionando o html no corpo do email
    $mail->Body = $msg;
//enviando e retornando o status de envio
    if ($mail->Send()) {
        return true;
    } else {
        return false;
    }
}

?>
