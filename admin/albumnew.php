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
        extract($_POST, EXTR_PREFIX_SAME, "");

        //FunÃ§Ãµes de validaÃ§Ã£o
        require_once($CONFIG->DIR_ROOT . "/includes/validacao.php");

        $dadosOK = true;
        $erro = array();
        $data = implode("-", array_reverse(explode("/", $data)));
        //Se dados OK insere no banco de dados
        if ($dadosOK) {

            $query = "INSERT INTO album(id,data,usuario,album,semtec) ";
            $query .= "VALUES('NULL','$data','$usuario','$album','$SCT_ID')";
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
    ?>
    <script language="javascript" type="text/javascript" src="<?php echo $CONFIG->URL_ROOT ?>/includes/js//datetimepicker.js"></script>
    <h1>Adicionar Album<span class="imgH1 geral"></span></h1>
    <br/>

    <p>
        Insira os dados do Albúm.
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

    <form class="forms" name="alt_evento" method="post" action="<?= $Esta_Pagina ?>">

        <input type="hidden" name="alterar_album" value="false" />
        <input type="hidden" name="id" value="<?php echo $editalbum ?>" />

        <label for="data"><?php HTML_RequiredField() ?>Selecione a Data:</label>
        <input type="text" name="data" id="data" maxlength="30" size="35" readonly /> <a href="javascript:NewCal('data','ddmmyyyy')"><img src="<?php echo $CONFIG->URL_ROOT ?>/includes/imgs/cal.gif" width="16" height="16" border="0" alt="Selecionar Data"></a>
        <br/><br/>

        <label for="usuario"><?php HTML_RequiredField() ?>Usuário do Picasa:</label>
        <input type="text" name="usuario" id="usuario" maxlength="50" size="35"/>
        <br/><br/>

        <label for="album"><?php HTML_RequiredField() ?>Albúm (Como encontrado na URL) :</label>
        <input type="text" name="album" id="album" maxlength="50" size="35"/>
        <br/><br/>

        <input type="submit" value="Adicionar album" />
    </form>
<? } ?>
