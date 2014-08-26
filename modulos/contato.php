<?php
#---------------------------------------------------------------------------#
if (isset($_POST['nome'])):
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $assunto = $_POST['assunto'];
    $msg = $_POST['msg'];
    $codigo = $_POST['codigo'];
    $dadosOK = true;


    //Nome
    if (strlen($nome) < 3) {
        $dadosOK = false;
    }

    //E-mail
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $dadosOK = false;
    }

    //Assunto
    if (strlen($assunto) < 3 || strlen($assunto) > 90) {
        $dadosOK = false;
    }

    //Mensagem
    if (strlen($msg) < 3) {
        $dadosOK = false;
    }

    if (strtolower($_POST['codigo']) != strtolower($_SESSION['letrasgd'])) {
        $dadosOK = false;
    }

    if ($dadosOK) {
        //Funções para envio da mensagem por email
        require_once($CONFIG->DIR_ROOT . "/includes/email_contato.php");
        $enviado = @email_contato($nome, $email, $assunto, $msg, $CONFIG->CONTATO_EMAIL);
        $tentativas = 1;

        while ($enviado == false && $tentativas <= 3) {
            sleep(2);
            $enviado = @email_contato($nome, $email, $assunto, $msg, $CONFIG->CONTATO_EMAIL);
            $tentativas++;
        }

        $dadosOK = $enviado ? true : false;

        //"Zera" os campos
        $nome = $email = $assunto = $msg = "";
    }
endif;
#---------------------------------------------------------------------------#  
//$header['css'][] = array("href"=>CSS_DIR."/contato.css", "media"=>"all");
$_SESSION['letrasgd'] = gerarLetras();
?>


<h1>Contato<span class="imgH1 geral"></span></h1>
<br/>
<p>
    Use esta p&aacute;gina para entrar em contato com a Comiss&atilde;o Organizadora, tirar d&uacute;vidas, fazer sugest&otilde;es ou cr&iacute;ticas.
    Todos os campos s&atilde;o de preenchimento obrigat&oacute;rio. <br><br>
    Esta p&aacute;gina tem a &uacute;nica finalidade de atender quest&otilde;es sobre <?php echo $EVENTO['GENERO'] ?> <?php echo $EVENTO['NOME'] ?>. 
    Qualquer outro assunto n&atilde;o ser&aacute; respondido.
</p>

<?php
//Mensagem de erro (se houver)
if (isset($dadosOK) && !$dadosOK) {
    HTML_ErrorMessage("Erro ao enviar mensagem. Todos os campos são obrigat&oacute;rios!<br/>Certifique-se de ter digitado os dados corretamente.");
}
if (isset($dadosOK) && $dadosOK === true) {
    HTML_SuccessMessage("Sua mensagem foi enviada com sucesso. Obrigado pelo contato!");
}
?>


<form class="forms contato" name="contato" method="post" action="<?php echo $Esta_Pagina; ?>">

    <?php HTML_RequiredMessage() ?>

    <label for="nome"><?php HTML_RequiredField() ?>Nome:</label><br/>
    <input type="text" name="nome" id="nome" maxlength="50" value="<?php echo $nome ?>" />
    <br/><br/>

    <label for="email"><?php HTML_RequiredField() ?>E-mail:</label><br/>
    <input type="text" name="email" id="email" maxlength="60" value="<?php echo $email ?>" />
    <br/><br/>

    <label for="assunto"><?php HTML_RequiredField() ?>Assunto:</label><br/>
    <input type="text" name="assunto" id="assunto" maxlength="90" value="<?php echo $assunto ?>" />
    <br/><br/>

    <label for="msg"><?php HTML_RequiredField() ?>Mensagem:</label><br/>
    <textarea name="msg" id="msg"><?php echo $msg ?></textarea>
    <br/><br/>

    <td align="center"><img name="codigo" src="includes/gdimg.php?letrasgd=<?php echo $_SESSION['letrasgd']; ?>" alt="codigo" /></td><br><br>


    <label for="codigo"><?php HTML_RequiredField() ?>Código imagem:</label><br/>
    <input type="text" name="codigo" id="codigo" maxlength="5" size="13" />
    <br/><br>

    <input type="submit" value="Enviar" />
</form>
