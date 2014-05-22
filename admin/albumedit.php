<?php
if (!$SESSION->IsLoggedIn()) {
    $Return_URL = "$CONFIG->URL_ROOT";
    header("Location: $Return_URL");
    unset($Return_URL);
}
if (tipoadmin(5, $USER->getCpf(), $SCT_ID)) {

//$query = "SELECT * FROM `album` WHERE `id` =".$_POST['album']."";
//$albuns = $DB->Query($query);
    if (isset($_POST['id'])):
        $editalbum = $_POST['id'];
    endif;
    if (isset($_GET['id'])):
        $editalbum = $_GET['id'];
    endif;
//Apenas para controle de exibição
    $primeiro = true;



//$header['css'][] = array("href"=>CSS_DIR."/programacao.css", "media"=>"all");
    ?>
    <?php
    if (isset($_POST['alterar_album'])):

        //Escapa as variÃveis
        $_POST = safe_sql($_POST);

        //Transforma os parametros em variaveis
        import_request_variables("P");

        $data = implode("-", array_reverse(explode("/", $data)));
        $dadosOK = true;
        $erro = array();

        //Se dados OK insere no banco de dados
        if ($dadosOK) {

            $query = "UPDATE album SET data='$data', usuario='$usuario', album='$album' ";
            $query .= "WHERE id='$editalbum'";
            //exit($query);

            if (!$DB->Query($query)) {
                $dadosOK = false;
                $erro['insert'] = "Erro ao inserir no banco de dados.";
            }
        }

    endif;
#---------------------------------------------------------------------------#

    $query = "SELECT * FROM `album` WHERE `id` = '$editalbum'";
    $result = mysql_fetch_array($DB->Query($query));
    $data = implode("/", array_reverse(explode("-", $result['data'])));
    ?>

    <h1>Alterar Album<span class="imgH1 geral"></span></h1>
    <br/>

    <p>
        Corrija os dados do album caso necess&aacute;rio.
    </p>

    <?php
//Mensagem de erro (se houver)
    if (isset($dadosOK) && !$dadosOK)
        HTML_ErrorMessage($erro);
//Mensagem de atualizaÃ§Ã£o OK
    if (isset($dadosOK) && $dadosOK)
        HTML_SuccessMessage("Seus dados foram atualizados com sucesso.");
    ?>

    <?php HTML_RequiredMessage() ?>
    <script language="javascript" type="text/javascript" src="<?php echo $CONFIG->URL_ROOT ?>/includes/js//datetimepicker.js"></script>


    <form class="forms" name="alt_evento" method="post" action="<?= $Esta_pagina ?>">

        <input type="hidden" name="alterar_album" value="false" />
        <input type="hidden" name="id" value="<?php echo $editalbum ?>" />
        <label for="id">
            <?php HTML_RequiredField() ?>ID do album: (apenas números)
        </label>
        <input type="text" name="id" id="id" maxlength="4" size="35" value="<?php echo $result['id'] ?>" disabled="disabled" />
        <br/><br/>

        <label for="data"><?php HTML_RequiredField() ?>Selecione a Data:</label>
        <input type="text" name="data" id="data" maxlength="30" size="35" value="<?php echo $data ?>" readonly /> <a href="javascript:NewCal('data','ddmmyyyy')"><img src="<?php echo $CONFIG->URL_ROOT ?>/includes/imgs/cal.gif" width="16" height="16" border="0" alt="Selecionar Data"></a>
        <br/><br/>

        <label for="usuario"><?php HTML_RequiredField() ?>Usuário do Picasa:</label>
        <input type="text" name="usuario" id="usuario" maxlength="50" size="35" value="<?php echo $result['usuario'] ?>" />
        <br/><br/>

        <label for="album"><?php HTML_RequiredField() ?>Albúm (Como encontrado na URL) :</label>
        <input type="text" name="album" id="album" maxlength="50" size="35" value="<?php echo $result['album'] ?>" />
        <br/><br/>

        <input type="submit" value="Atualizar album" />
    </form>

<? } ?>
