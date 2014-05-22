<?php
if (!$SESSION->IsLoggedIn()) {
    $Return_URL = "$CONFIG->URL_ROOT";
    header("Location: $Return_URL");
    unset($Return_URL);
}
if (tipoadmin(2, $USER->getCpf(), $SCT_ID)) {
    $SNCTID = $SCT_ID; //SCT_ID;
//$query = "SELECT * FROM `eventos` WHERE `id` =".$_POST['evento']."";
//$eventos = $DB->Query($query);
    if (isset($_POST['id'])):
        $editevento = $_POST['id'];
    endif;
    if (isset($_GET['id'])):
        $editevento = $_GET['id'];
    endif;
    if (isset($_GET['SCT_ID'])) {
        $SNCTID = $_GET['SCT_ID'];
    }
    if (isset($_GET['evento'])):
        $evento = $_GET['evento'];
    endif;
//Apenas para controle de exibição
    $primeiro = true;



//$header['css'][] = array("href"=>CSS_DIR."/programacao.css", "media"=>"all");
    ?>
    <?php
    if (isset($_POST['alterar_evento'])):

        //Escapa as variÃveis
        $_POST = safe_sql($_POST);
        //Transforma os parametros em variaveis
        import_request_variables("P");

        //FunÃ§Ãµes de validaÃ§Ã£o
        require_once($CONFIG->DIR_ROOT . "/includes/validacao.php");


        $dadosOK = true;
        $erro = array();

        //Se dados OK insere no banco de dados
        if ($dadosOK) {
            $query = "INSERT INTO part_palestrante(cod_palestrante,cod_palestra) ";
            $query .= "VALUES('$cod_palestrante','$evento')";
            //exit($query);

            if (!$DB->Query($query)) {
                $dadosOK = false;
                $erro['insert'] = "Erro ao inserir no banco de dados.";
            }
        }

    endif;

    if (isset($_POST['busca'])) {
        $busca = $_POST['busca'];
        $query = "SELECT codigo, palestrante FROM palestrante WHERE palestrante LIKE '%$busca%'";
    } else {
        $query = "SELECT codigo, palestrante FROM palestrante";
    }
    $Palestrantes = $DB->Query($query);

#---------------------------------------------------------------------------#
//$query = "SELECT * FROM `eventos` WHERE `id` = '$editevento'";
//$result = mysql_fetch_array($DB->Query($query));
    ?>

    <h1>Inscrever Palestrante<span class="imgH1 geral"></span></h1>
    <br/>
    <?
    $query = "SELECT titulo FROM eventos WHERE id = '$evento'";
    $result = mysql_fetch_array($DB->Query($query));
    ?>
    <p>
        Insira os palestrantes do evento <?= $evento ?> - <?= $result['titulo'] ?>
    </p>

    <?php
//Mensagem de erro (se houver)
    if (isset($dadosOK) && !$dadosOK)
        HTML_ErrorMessage($erro);
//Mensagem de atualizaÃ§Ã£o OK
    if (isset($dadosOK) && $dadosOK)
        HTML_SuccessMessage("Seus dados foram inseridos com sucesso.");
    ?>

    <?php HTML_RequiredMessage() ?>
    <form class="forms" name="buscar_palestrante" method="post" action="<?= $Esta_pagina ?>">
        <label for="busca">Buscar Palestrante:</label>
        <input type="text" name="busca" id="busca" maxlength="35" size="35" value="<?= $busca ?>" />
        <br/><br/>
        <input type="submit" value="Buscar" />
    </form>

    <form class="forms" name="alt_evento" method="post" action="<?= $Esta_pagina ?>">
        <input type="hidden" name="alterar_evento" value="false" />
        <label for="evento"><?php HTML_RequiredField() ?>Palestrante:</label>

        <select name="cod_palestrante" style="width:650px; height: 30px">
            <?
            if (@mysql_num_rows($Palestrantes) <= 0):
                echo "<option value=\"0\"><i>Nenhum Palestrante Encontrado</i></option>";
            else:
                echo "<option value=\"\" selected><i>**Selecione**</i></option>";
                while ($x = mysql_fetch_array($Palestrantes)):
                    ?>

                    <option value="<?= $x['codigo'] ?>" <?= $evento_op2 == $x['codigo'] ? 'selected="selected"' : '' ?>><?= $x['codigo'] ?> - <?= $x['palestrante'] ?></option>
                    <?
                endwhile;
            endif;
            ?>
        </select>
        <br/><br/>	

        <input type="submit" value="Inserir Participação" />
    </form>
<? } ?>
