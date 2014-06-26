<?php
#---------------------------------------------------------------------------#
$QuantidadeTotalOral = 50;
$QuantidadeTotalPoster = 5000;
$DataFinal = strtotime("2013-09-23 23:59:59");

if (!file_exists($CONFIG->DIR_ROOT . "/templates/" . $EVENTO['TEMPLATE'] . "/db/submissao/submissao.nodb")) {
    if (!copy($CONFIG->DIR_ROOT . "/templates/" . $EVENTO['TEMPLATE'] . "/db/submissao/submissao-dist.nodb", $CONFIG->DIR_ROOT . "/templates/" . $EVENTO['TEMPLATE'] . "/db/submissao/submissao.nodb")) {
        echo "Falha ao criar NODB...\n";
    }
}

require($CONFIG->DIR_ROOT . "/templates/" . $EVENTO['TEMPLATE'] . "/nodb_functions.php");
if (isset($_POST['nome'])):
    $nome = retira_acentos($_POST['nome']);
    $email = retira_acentos($_POST['email']);
    $emaileixo = $_POST['emaileixo'];
    $periodo = $_POST['periodo'];
    $tipo = $_POST['tipo'];
    $files = $$_POST['files'];
    $dadosOK = true;
    if (mime_content_type($_FILES['files']['tmp_name']) != "application/pdf") {
        $dadosOK = false;
    }
    //Nome
    if (strlen($nome) < 3) {
        $dadosOK = false;
    }

    //E-mail
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $dadosOK = false;
    }
    //E-mail
    if (strlen($_FILES['files']['name']) == 0) {
        $dadosOK = false;
    }

    if ($emaileixo == "") {
        $dadosOK = false;
    }

    if ($periodo == "") {
        $dadosOK = false;
    }

    if ($tipo == "") {
        $dadosOK = false;
    }

    if (strtolower($_POST['codigo']) != strtolower($_SESSION['letrasgd'])) {
        $dadosOK = false;
    }

    if ($dadosOK) {
        //Funções para envio da mensagem por email
        require_once($CONFIG->DIR_ROOT . "/templates/" . $EVENTO['TEMPLATE'] . "/email_submissao.php");

        $enviado = email_submissao($nome, $email, $emaileixo, $tipo, $_FILES['files']['name'], $_FILES['files']['tmp_name'], $_FILES['files']['size'], $periodo);
        $tentativas = 1;

        while ($enviado == false && $tentativas <= 3) {
            sleep(2);
            $enviado = email_submissao($nome, $email, $emaileixo, $tipo, $_FILES['files']['name'], $_FILES['files']['tmp_name'], $_FILES['files']['size'], $periodo);
            $tentativas++;
        }

        $dadosOK = $enviado ? true : false;

        //"Zera" os campos
        $nome = $email = $emaileixo = $tipo = "";
    }
endif;
#---------------------------------------------------------------------------#  
//$header['css'][] = array("href"=>CSS_DIR."/contato.css", "media"=>"all");
$_SESSION['letrasgd'] = gerarLetras();
require_once($CONFIG->DIR_ROOT . "/templates/" . $EVENTO['TEMPLATE'] . "/nodb_functions.php");
$QuantidadeOral = Count(searchDatabase($searchfor = "Oral", $column = "tipo", "submissao.nodb", "submissao", $CONFIG->DIR_ROOT . "/templates/" . $EVENTO['TEMPLATE'] . "/db", false));
$QuantidadePoster = Count(searchDatabase($searchfor = "Poster", $column = "tipo", "submissao.nodb", "submissao", $CONFIG->DIR_ROOT . "/templates/" . $EVENTO['TEMPLATE'] . "/db", false));
?>
<?php
//Mensagem de erro (se houver)
if (isset($dadosOK) && !$dadosOK) {
    HTML_ErrorMessage("Erro! Todos os campos são obrigat&oacute;rios!<br/>O Arquivo deverá ser pdf<br/>Certifique-se de ter digitado os dados corretamente.");
}
if (isset($dadosOK) && $dadosOK === true) {
    HTML_SuccessMessage("Submissão enviada com sucesso! Aguarde contato");
}
?>
<? require_once($CONFIG->DIR_ROOT . "/templates/" . $EVENTO['TEMPLATE'] . "/textosubmissao.php"); ?>
<?php if (($QuantidadeOral < $QuantidadeTotalOral) || ($QuantidadePoster < $QuantidadeTotalPoster)): ?>
    <?php if (time() < $DataFinal): ?>
        <form class="forms"  name="email" action="<?= $Esta_Pagina ?>" method="POST" enctype="multipart/form-data"/>
        <label for="eixo"><span class="required-field">*</span> Eixo tecnológico:</label><br />
        <select name="emaileixo" id="emaileixo">
            <option value = ""  selected> ** Selecione **
            <option value = "CIINED" <? if ($emaileixo == "CIINED") echo selected ?> > Ciência, Inovação e Educação
            <option value = "CIINSA" <? if ($emaileixo == "CIINSA") echo selected ?> > Ciência e Inovação em Saúde
            <option value = "CIINES" <? if ($emaileixo == "CIINES") echo selected ?> > Ciência e Inovação em Esporte
            <option value = "PRLOSU" <? if ($emaileixo == "PRLOSU") echo selected ?> > Práticas Locais Sustentáveis
            <!-- <option value = "TEST" <? if ($emaileixo == "TEST") echo selected ?> > TESTE DE ENVIO -->
        </select><br/><br/>

        <label for="eixo"><span class="required-field">*</span> Tipo:</label><br />
        <select name="tipo" id="tipo">
            <option value = ""  selected> ** Selecione **
                <? if ($QuantidadePoster < $QuantidadeTotalPoster) : ?>
                <option value = "Poster" <? if ($tipo == "Poster") echo selected ?> > Poster
                <? endif ?>
                <? if ($QuantidadeOral < $QuantidadeTotalOral) : ?>
                <option value = "Oral" <? if ($tipo == "Oral") echo selected ?> > Comunicação Oral
                <? endif ?>
        </select><br/><br/>
        <label for="nome"><?php HTML_RequiredField() ?>Nome:</label><br/>
        <input type="text" value="<?= $nome ?>" name="nome" size="50" /><br /><br />
        <label for="nome"><?php HTML_RequiredField() ?>E-mail:</label><br/>
        <input type="text" value="<?= $email ?>" name="email" /><br /> <br />
        <label for="nome"><?php HTML_RequiredField() ?>Arquivo:</label><br/>
        <input type="file" value="<?= $files ?>" name="files" /><br /><br />
        <label for="nome"><?php HTML_RequiredField() ?>Disponibilidade:</label><br/>
        <select name="periodo" id="periodo">
            <option value = ""  selected> ** Selecione **
            <option value = "MANHA" <? if ($emaileixo == "MANHA") echo selected ?> > Manhã
            <option value = "TARDE" <? if ($emaileixo == "TARDE") echo selected ?> > Tarde
            <option value = "NOITE" <? if ($emaileixo == "NOITE") echo selected ?> > Noite
        </select><br/><br/>
        <div style="border:2px solid; border-radius:25px;"><br>
            &nbsp;&nbsp;&nbsp;<img name="codigo" src="includes/gdimg.php?letrasgd=<?php echo $_SESSION['letrasgd'];?>" alt="codigo" /><br><br>
            &nbsp;&nbsp;&nbsp;<label for="codigo"><?php HTML_RequiredField() ?>Código imagem:</label><br/>
            &nbsp;&nbsp;&nbsp;<input type="text" name="codigo" id="codigo" maxlength="5" size="13" />
            <br/><br>
        </div>
        <br/><br>
        <input type="submit" value="Enviar" name="sub" /> 
        </form> 

    <?php else : ?>

        <h3>A submissão de trabalhos está finalizada</h3>

    <?php endif; ?>
<?php else : ?>

    <h3>A submissão de trabalhos está finalizada</h3>

<?php endif; ?>