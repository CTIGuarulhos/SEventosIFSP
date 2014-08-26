<?php
require "initialize.php";
$Esta_Pagina = basename(__FILE__);
$erro['OK'] = false;

//Se o formulário foi submetido...
if (isset($_POST['codigo'])) {
    $email = safe_sql($_REQUEST['femail']);
    $query = "SELECT * FROM participantes WHERE email='$email'";
    $result = $DB->Query($query);

    // Verifica se o email existe
    if (mysql_num_rows($result) > 0) {
        $result = mysql_fetch_array($result);
        $email = $result['email'];

        // Verifica o código de confirmação...
        if (strtolower($_POST['codigo']) == strtolower($_SESSION['letrasgd'])) {
            require_once($CONFIG->DIR_ROOT . '/includes/email_senha.php');
            $novasenha = novaSenha();
            $senhamd5 = md5($novasenha);

            if (email_senha($result['nome'], $novasenha, $result['email'], $result['cod_confirmacao'], $result['confirmado'])) {
                $query = "UPDATE participantes SET senha='$senhamd5' WHERE email='$email'";
                $enviado = $DB->Query($query);

                if (!$enviado) {
                    $i = 1;
                    while (!enviado && $i <= 3) {
                        sleep(2);
                        $enviado = $DB->Query($query);
                        $i++;
                    }
                }

                email_enviado($result['email']);
                unset($_SESSION['letrasgd']);
                @logNovaSenha($result['cpf'], $result['email']);
                exit;
            } //Caso tenha sido enviada com sucesso o script acaba aqui.
            else {

                $erro['OK'] = true;
                $erro['MSG'] = "<div id=\"erro\">\n
					<b><font color=\"white\">Erro ao enviar mensagem de e-mail.<br/>\n
					Tente novamente.</font></b>\n
					</div>\n";
                //Muda as letras da sessão...
                $_SESSION['letrasgd'] = gerarLetras();
            }
        } else {
            $erro['OK'] = true;
            $erro['MSG'] = "<div id=\"erro\">\n
			<b><font color=\"white\">C&oacute;digo de verifica&ccedil&atilde;o inv&aacute;lido.<br/>\n
			Verifique e digite novamente.</font></b>\n
			</div>\n";
            //Muda as letras da sessão...
            $_SESSION['letrasgd'] = gerarLetras();
        }
    } else {
        $erro['OK'] = true;
        $erro['MSG'] = "<div id=\"erro\">\n
			<b><font color=\"white\">E-mail n&atilde;o cadastrado.<br/>\n
			Tente novamente.</font></b>\n
			</div>\n";
        //Muda as letras da sessão...
        $_SESSION['letrasgd'] = gerarLetras();
    }
} else {

    $_SESSION['letrasgd'] = gerarLetras();
}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="pt-BR">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <title>Não Consigo Acessar</title>
        <style type="text/css">
            table { border: thin #D5D5D5 solid; }
            table td { background-color: #F8F8F8; }
            #erro {
                background: #EBABAE url('<?php echo $CONFIG->URL_ROOT ?>/templates/<?php echo $EVENTO['TEMPLATE'] ?>/imgs/warning.png') left center no-repeat;
                width:100%;
            }
        </style>
    </head>

    <body bgcolor="#FFFFFF">

        <img name="logo" src="<?php echo $CONFIG->URL_ROOT ?>/templates/<?php echo $EVENTO['TEMPLATE'] ?>/imgs/logo.png" alt="logo" /><br/>
        <center>
            <br/><b>Não Consigo Acessar</b><br/>

            <?php echo $erro['OK'] ? $erro['MSG'] : "\n"; ?><br/>

            <form name="sendmail" method="post" action="<?php echo $Esta_Pagina ?>">
                <table border="0" cellpadding="1" cellspacing="2">
                    <tr>
                        <td>E-Mail:</td>
                        <td><input type="text" size="18" maxlength="50" name="femail" /></td>
                    </tr>

                    <tr>
                        <td>Código de confirma&ccedil&atilde;o:</td>
                        <td><input type="text" name="codigo" size="18" maxlength="3" /></td>
                    </tr>

                    <tr>
                        <td align="center"><img name="codigo" src="includes/gdimg.php?letrasgd=<?php echo $_SESSION['letrasgd']; ?>" alt="codigo" /></td>
                        <td align="center"><input type="submit" id="enviar" value="Enviar" /></td>
                    </tr>
                </table>
            </form>
        </center>
        <?php
// TESTE
//echo "_SESSION['letrasgd'] = '{$_SESSION['letrasgd']}'<br/>";
//exit;
        ?>

    </body>
</html>



<?php

function novaSenha() {
    $var = "";
    for ($i = 1; $i <= 8; $i++)
        $var .= substr("abcdefghijklmnopqrstuvwxyz1234567890", rand(0, 35), 1);
    return str_shuffle($var);
}

function email_enviado($email) {
    ?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="pt-BR">
        <head>
            <meta http-equiv="content-type" content="text/html; charset=utf-8" />
            <title>Recuperar Senha</title>
            <style type="text/css">
                table { border: thin #D5D5D5 solid; }
                table td { background-color: #F8F8F8; }
                #OK {
                    background: rgb(173,223,161) url('includes/imgs/ok.png') left center no-repeat;
                    width:100%;
                }
            </style>
        </head>

        <body>  
            <img name="logo" src="includes/imgs/logo-ifsp.png" alt="logo" />
            <br/><br/>
            <center>
                <div id="OK">
                    <b><font color="white" size="3">Mensagem enviada com sucesso.
                            <br/>
                            Siga as informações que foram enviadas para o e-mail <b><?php echo $email ?></b>.
                        </font></b>
                </div>
                <br/><br/>
                <input type="button" value="Fechar" onClick="javascript:window.close();" />
            </center>
        </body></html>
    <?php
}

function logNovaSenha($cpf, $email) {
    global $CONFG;

    $arquivo = $CONFG->DIR_ROOT . '/Log_ReqSenha.txt';
    $file = fopen($arquivo, 'a');

    $txt = date('d-m-Y H:i:s') . "\r\n";
    $txt .= $cpf . " - " . $email . "\r\n\r\n";

    fwrite($file, $txt);
    fclose($file);
}
?>
