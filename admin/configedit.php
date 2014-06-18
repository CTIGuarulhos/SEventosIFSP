<?php
if (!$SESSION->IsLoggedIn()) {
    $Return_URL = "$CONFIG->URL_ROOT";
    header("Location: $Return_URL");
    unset($Return_URL);
}
if (tipoadmin(7, $USER->getCpf(), $SCT_ID)) {
//$query = "SELECT * FROM `eventos` WHERE `id` =".$_POST['evento']."";
//$eventos = $DB->Query($query);
    if (isset($_POST['id'])):
        $editevento = $_POST['id'];
    endif;
    if (isset($_GET['id'])):
        $editevento = $_GET['id'];
    endif;
//Apenas para controle de exibição
    $primeiro = true;



//$header['css'][] = array("href"=>CSS_DIR."/programacao.css", "media"=>"all");
    ?>
    <?php
    if (isset($_POST['alterar_edicao'])):

        //Escapa as variÃveis
        $_POST = safe_sql($_POST);

        //Transforma os parametros em variaveis
        extract($_POST, EXTR_PREFIX_SAME, "");


        $dadosOK = true;
        $erro = array();
        //Se dados OK insere no banco de dados
        if ($dadosOK) {
            $mes = $_POST['mes'];
            $query = "UPDATE edicao SET GENERO='$genero', NOME='$nome', CADASTRO='$cadastro', TEMPLATE='$template', URL_INST='$url_inst', ";
            $query .= "NOME_INST_RED='$nome_inst_red', NOME_INST_COMP='$nome_inst_comp', ENDERECO_L1='$endereco_l1', ENDERECO_L2='$endereco_l2', URL_MAPS_IFRAME='$url_maps_iframe', ";
            $query .= "URL_MAPS='$url_maps', DIA_INICIO='$dia_inicio', DIA_FIM='$dia_fim', MES='$mes', ANO='$ano', ";
            $query .= "HORA='$hora', MINUTO='$minuto', LIBERACAO='$liberacao', APRESENTACAO='$apresentacao', DATASIMPORTANTES='$datasimportantes', COMISSAOORGANIZADORA='$comissaoorganizadora', ";
            $query .= "PALESTRANTESCONFIRMADOS='$palestrantesconfirmados' WHERE SEMTEC='$SCT_ID'";
            //exit($query);

            if (!$DB->Query($query)) {
                $dadosOK = false;
                $erro['insert'] = "Erro ao inserir no banco de dados.";
            }
        }

    endif;
#---------------------------------------------------------------------------#
    $query = "SELECT * FROM edicao WHERE SEMTEC='$SCT_ID'";
    $result = mysql_fetch_array($DB->Query($query));
    ?>
    <script language="javascript" type="text/javascript" src="<?php echo $CONFIG->URL_ROOT ?>/includes/js/datetimepicker.js"></script>

    <h1>Alterar Evento<span class="imgH1 geral"></span></h1>
    <br/>

    <p>
        Corrija os dados do evento caso necess&aacute;rio.
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

    <form class="forms" name="alt_edicao" method="post" action="<?= $Esta_pagina ?>">

        <input type="hidden" name="alterar_edicao" value="false" />
        <input type="hidden" name="id" value="<?php echo $editedicao ?>" />
        <label for="id">
            <?php HTML_RequiredField() ?>Código do Evento: (apenas números)
        </label>
        <input type="text" name="semtec" id="semtec" maxlength="4" size="4" value="<?php echo $result['SEMTEC'] ?>" disabled="disabled" />
        <br/><br/>
        <label for="genero"><?php HTML_RequiredField() ?>Genero do Nome do Evento:</label>
        <select name="genero" id="genero">
            <option value = "a" <?php
            if ($result['GENERO'] == "a") {
                echo " selected";
            }
            ?>>A</option>
            <option value = "o" <?php
            if ($result['GENERO'] == "o") {
                echo " selected";
            }
            ?>>O</option>
        </select>
        <br/><br/>

        <label for="nome"><?php HTML_RequiredField() ?>Nome:</label>
        <input type="text" name="nome" id="nome" maxlength="127" size="35" value="<?php echo $result['NOME'] ?>" />
        <br/><br/>

        <label for="cadastro"><?php HTML_RequiredField() ?>Cadastro:</label>
        <select name="cadastro" id="cadastro">
            <option value = "aberto" <?php
            if ($result['CADASTRO'] == "aberto") {
                echo " selected";
            }
            ?>>Aberto</option>
            <option value = "fechado" <?php
            if ($result['CADASTRO'] == "fechado") {
                echo " selected";
            }
            ?>>Fechado</option>
        </select>
        <br/><br/>

        <label for="template"><?php HTML_RequiredField() ?>Template:</label>
        <select name="template" id="template">
            <option value = "Default"></option>
            <? showDir($CONFIG->DIR_ROOT . "/templates/", $result['TEMPLATE']); ?>
        </select>
        <br/><br/>

        <label for="urlinst"><?php HTML_RequiredField() ?>URL da Instituição:</label>
        <input type="text" name="url_inst" id="url_inst" maxlength="127" size="35" value="<?php echo $result['URL_INST'] ?>" />
        <br/><br/>

        <label for="nome_inst_red"><?php HTML_RequiredField() ?>Nome da Instituição Reduzido:</label>
        <input type="text" name="nome_inst_red" id="nome_inst_red" maxlength="127" size="35" value="<?php echo $result['NOME_INST_RED'] ?>" />
        <br/><br/>

        <label for="nome_inst_comp"><?php HTML_RequiredField() ?>Nome da Instituição Completo:</label>
        <input type="text" name="nome_inst_comp" id="nome_inst_comp" maxlength="127" size="35" value="<?php echo $result['NOME_INST_COMP'] ?>" />
        <br/><br/>

        <label for="endereco_l1"><?php HTML_RequiredField() ?>Endereço Linha 1:</label>
        <input type="text" name="endereco_l1" id="endereco_l1" maxlength="127" size="35" value="<?php echo $result['ENDERECO_L1'] ?>" />
        <br/><br/>

        <label for="endereco_l2"><?php HTML_RequiredField() ?>Endereço Linha 2:</label>
        <input type="text" name="endereco_l2" id="endereco_l2" maxlength="127" size="35" value="<?php echo $result['ENDERECO_L2'] ?>" />
        <br/><br/>

        <label for="url_maps_iframe"><?php HTML_RequiredField() ?>URL Google Maps (Iframe):</label>
        <input type="text" name="url_maps_iframe" id="url_maps_iframe" maxlength="1000" size="35" value="<?php echo $result['URL_MAPS_IFRAME'] ?>" />
        <br/><br/>

        <label for="url_maps"><?php HTML_RequiredField() ?>URL Google Maps:</label>
        <input type="text" name="url_maps" id="url_maps" maxlength="127" size="35" value="<?php echo $result['URL_MAPS'] ?>" />
        <br/><br/>

        <label for="dia_inicio"><?php HTML_RequiredField() ?>Dia de Inicio:</label>
        <input type="text" name="dia_inicio" id="dia_inicio" maxlength="127" size="35" value="<?php echo $result['DIA_INICIO'] ?>" />
        <br/><br/>

        <label for="dia_fim"><?php HTML_RequiredField() ?>Dia de Fim:</label>
        <input type="text" name="dia_fim" id="dia_fim" maxlength="127" size="35" value="<?php echo $result['DIA_FIM'] ?>" />
        <br/><br/>

        <label for="mes"><?php HTML_RequiredField() ?>Mes do Evento:</label>
        <input type="text" name="mes" id="mes" maxlength="127" size="35" value="<?php echo $result['MES'] ?>" />
        <br/><br/>

        <label for="ano"><?php HTML_RequiredField() ?>Ano do Evento:</label>
        <input type="text" name="ano" id="ano" maxlength="127" size="35" value="<?php echo $result['ANO'] ?>" />
        <br/><br/>

        <label for="hora"><?php HTML_RequiredField() ?>Hora da 1ª Cerimonia:</label>
        <input type="text" name="hora" id="hora" maxlength="127" size="35" value="<?php echo $result['HORA'] ?>" />
        <br/><br/>

        <label for="minuto"><?php HTML_RequiredField() ?>Minuto da 1ª Cerimonia:</label>
        <input type="text" name="minuto" id="minuto" maxlength="127" size="35" value="<?php echo $result['MINUTO'] ?>" />
        <br/><br/>

        <label for="minuto"><?php HTML_RequiredField() ?>Tempo para Liberação da<br>fila de espera (em minutos):</label>
        <input type="text" name="liberacao" id="liberacao" maxlength="127" size="35" value="<?php echo $result['LIBERACAO'] ?>" />
        <br/><br/>


        <label for="apresentacao"><?php HTML_RequiredField() ?>Apresentação:</label>
        <textarea name="apresentacao" id="apresentacao"><?php echo $result['APRESENTACAO'] ?></textarea>
        <br/><br/>

        <label for="datasimportantes"><?php HTML_RequiredField() ?>Datas Importantes:</label>
        <textarea name="datasimportantes" id="datasimportantes"><?php echo $result['DATASIMPORTANTES'] ?></textarea>
        <br/><br/>

        <label for="comissaoorganizadora"><?php HTML_RequiredField() ?>Comissão Organizadora:</label>
        <textarea name="comissaoorganizadora" id="comissaoorganizadora"><?php echo $result['COMISSAOORGANIZADORA'] ?></textarea>
        <br/><br/>

        <label for="palestrantesconfirmados"><?php HTML_RequiredField() ?>Palestrantes Confirmados:</label>
        <textarea name="palestrantesconfirmados" id="palestrantesconfirmados"><?php echo $result['PALESTRANTESCONFIRMADOS'] ?></textarea>
        <br/><br/>


        <input type="submit" value="Atualizar evento" />
    </form>

<? }
?>
