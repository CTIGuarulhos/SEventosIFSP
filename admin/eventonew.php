<?php
if (!$SESSION->IsLoggedIn()) {
    $Return_URL = "$CONFIG->URL_ROOT";
    header("Location: $Return_URL");
    unset($Return_URL);
}
if (tipoadmin(5, $USER->getCpf(), $SCT_ID)) {
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
    if (isset($_POST['alterar_evento'])):

        //Escapa as variÃveis
        $_POST = safe_sql($_POST);

        //Transforma os parametros em variaveis
        extract($_POST, EXTR_PREFIX_SAME, "");

        //FunÃ§Ãµes de validaÃ§Ã£o
        require_once($CONFIG->DIR_ROOT . "/includes/validacao.php");
        require_once($CONFIG->DIR_ROOT . "/includes/validacao.php");

        $dadosOK = true;
        $erro = array();
        $datahoraparte = explode(" ", $datahora);
        $data = $datahoraparte[0];
        $data = implode("-", array_reverse(explode("/", $data)));
        $hora = $datahoraparte[1];
        //Se dados OK insere no banco de dados
        if ($dadosOK) {

            $query = "INSERT INTO eventos(id,tipo,titulo,descricao,data,hora,local,duracao,vagas,semtec) ";
            $query .= "VALUES('NULL','$tipo','$titulo','$descricao','$data','$hora','$local','$duracao','$vagas','$SCT_ID')";
            //exit($query);

            if (!$DB->Query($query)) {
                $dadosOK = false;
                $erro['insert'] = "Erro ao inserir no banco de dados.";
            }
        }

    endif;
#---------------------------------------------------------------------------#

    $query = "SELECT * FROM `eventos` WHERE `id` = '$editevento'";
    $result = mysql_fetch_array($DB->Query($query));
    ?>
    <script language="javascript" type="text/javascript" src="<?php echo $CONFIG->URL_ROOT ?>/includes/js//datetimepicker.js"></script>

    <h1>Adicionar Atividade<span class="imgH1 geral"></span></h1>
    <br/>

    <p>
        Insira os dados da Atividade.
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

    <form class="forms" name="alt_evento" method="post" action="<?= $Esta_Pagina ?>">

        <input type="hidden" name="alterar_evento" value="false" />
        <input type="hidden" name="id" value="<?php echo $editevento ?>" />
        <input type="hidden" name="sigla" id="sigla" maxlength="50" size="35" />	
        <!--		<label for="id">
        <?php HTML_RequiredField() ?>ID do evento: (apenas números)
        </label>
        <input type="text" name="id" id="id" maxlength="4" size="35" value="<?php echo $result['id'] ?>" disabled="disabled" />
        <br/><br/> -->

        <label for="tipo"><?php HTML_RequiredField() ?>Tipo:</label>
        <select name="tipo" id="tipo">
            <option value = "0" <?
            if ($result['tipo'] == 0) {
                echo " selected";
            }
            ?>> Outros
            <option value = "1" <?
            if ($result['tipo'] == 1) {
                echo " selected";
            }
            ?>> Palestra
            <option value = "2" <?
            if ($result['tipo'] == 2) {
                echo " selected";
            }
            ?>> Mini-Curso
            <option value = "3" <?
            if ($result['tipo'] == 3) {
                echo " selected";
            }
            ?>> Mesa Redonda
            <option value = "4" <?
            if ($result['tipo'] == 4) {
                echo " selected";
            }
            ?>> Seção Oral
            <option value = "5" <?
            if ($result['tipo'] == 5) {
                echo " selected";
            }
            ?>> Oficina
        </select>


        <br/><br/>

        <label for="titulo"><?php HTML_RequiredField() ?>Título:</label>
        <input type="text" name="titulo" id="titulo" maxlength="127" size="35"/>
        <br/><br/>

        <label for="descricao"><?php HTML_RequiredField() ?>Descrição:</label>
        <textarea name="descricao" id="descricao"></textarea>
        <br/><br/>
        <!--
        <label for="data"><?php HTML_RequiredField() ?>Data: (formato: 2011-12-31):</label>
        <input type="text" name="data" id="data" maxlength="30" size="35" />
        <br/><br/>

        <label for="hora"><?php HTML_RequiredField() ?>Hora: (formato: 23:59:59)</label>
        <input type="text" name="hora" id="hora" maxlength="8" size="35" /><a href="javascript:NewCal('datahora','ddmmyyyy',true,24)"><img src="images/cal.gif" width="16" height="16" border="0" alt="Pick a date"></a>
        <br/><br/>
        -->
        <label for="hora"><?php HTML_RequiredField() ?>Selecione data e hora</label>
        <input type="text" name="datahora" id="datahora" maxlength="8" size="35"  readonly /> <a href="javascript:NewCal('datahora','ddmmyyyy',true,24)"><img src="<?php echo $CONFIG->URL_ROOT ?>/includes/imgs/cal.gif" width="16" height="16" border="0" alt="Selecionar Data/Hora"></a>
        <br/><br/>			

        <label for="local"><?php HTML_RequiredField() ?>Local:</label>
        <input type="text" name="local" id="local" maxlength="50" size="35" />
        <br/><br/>

        <label for="duracao"><?php HTML_RequiredField() ?>Duração (em minutos):</label>
        <input type="text" name="duracao" id="duracao" maxlength="50" size="35" />
        <br/><br/>

        <label for="vagas"><?php HTML_RequiredField() ?>Quantidade de Vagas:</label>
        <input type="text" name="vagas" id="vagas" maxlength="30" size="35" />
        <br/><br/>	

        <input type="submit" value="Inserir evento" />
    </form>

<? } ?>
