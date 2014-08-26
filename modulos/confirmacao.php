<?php
#---------------------------------------------------------------------------#
if (isset($_REQUEST['codigo'])):

    $codigo = safe_sql($_REQUEST['codigo']);
    $query = "SELECT email FROM participantes WHERE cod_confirmacao='$codigo'";
    $result = $DB->Query($query);

    if (@mysql_num_rows($result) > 0) {
        $result = mysql_fetch_array($result);
        $query = "UPDATE participantes SET confirmado='1' WHERE email='{$result[0]}'";
        if ($DB->Query($query))
            $confirmado = true;
        else
            $confirmado = false;
    } else {
        $confirmado = false;
    }

endif;
#---------------------------------------------------------------------------#
?>

<h1>Confirmação<span class="imgH1 geral"></span></h1>

<div class="box">

    <p>
        Ap&oacute;s criar sua conta, voc&ecirc; receber&aacute; no seu endere&ccedil;o de e-mail um link de
        confirma&ccedil;&atilde;o. &eacute; preciso confirma-lo para poder ativar sua conta.
    </p>

    <br/>

    <?php
    //Mensagem de erro de envio da chave de confirmaçao
    if ($_SESSION['temp']['erro_email']) {
        $msg = "Erro ao enviar e-mail de confirma&ccedil;&atilde;o.<br/>";
        $msg .= "Entre em contato conosco, pelo menu CONTATO, e solicite o reenvio da sua chave de acesso.";
        HTML_ErrorMessage($msg);
        unset($_SESSION['temp']['erro_email']);
    }

    //Mensagem de sucesso
    if ($_SESSION['temp']['cadastro_ok']) {
        $msg = "Cadastro efetuado com sucesso.<br/>";
        $msg .= "Um link de confirma&ccedil;ao foi enviado ao seu endere&ccedil;o de e-mail.<br/>";
        $msg .= "Para ativar sua conta clique no link enviado para o seu e-mail.";
        HTML_SuccessMessage($msg);
        unset($_SESSION['temp']['cadastro_ok']);
    }

    //Conta confirmada
    if (isset($confirmado) && $confirmado == true) {
        $msg = "Conta confirmada com sucesso.<br/>";
        $msg .= "Pronto! Agora voc&ecirc; pode inscrever-se nas palestras e mini-cursos.<br/>";
        $msg .= "Fa&ccedil;a login nos campos indicados do menu ao lado.";
        HTML_SuccessMessage($msg);
    }

    //Erro de confirmação
    if (isset($confirmado) && $confirmado == false) {
        $msg = "C&oacute;digo de confirma&ccedil;ao inv&aacute;lido.<br/>";
        $msg .= "Certifique-se de ter digitado o link corretamente.";
        HTML_ErrorMessage($msg);
    }
    ?>

</div>