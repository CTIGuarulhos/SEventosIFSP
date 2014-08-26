<?php
if (!$SESSION->IsLoggedIn()) {
    $Return_URL = "$CONFIG->URL_ROOT";
    header("Location: $Return_URL");
    unset($Return_URL);
}
if (tipoadmin(1, $USER->getCpf(), $SCT_ID)) {
    $SNCTID = $SCT_ID; //SCT_ID;
# ----------------------- Par�metros GET/POST ----------------------------- #
    $listar = safe_sql($_REQUEST['listar']);
    $listar = (empty($listar) || $listar < 0 || $listar > 2) ? 0 : $listar;
    $opcao = safe_sql($_REQUEST['opcao']);
    $evento_op2 = safe_sql($_REQUEST['evento_op2']);
    $busca = safe_sql($_REQUEST['busca']);
# ------------------------------------------------------------------------- #
    $header['css'][] = array("href" => $CONFIG->URL_ROOT . "/templates/" . $EVENTO['TEMPLATE'] . "/css/relatorios.css", "media" => "screen");
    $header['css'][] = array("href" => $CONFIG->URL_ROOT . "/templates/" . $EVENTO['TEMPLATE'] . "/css/relatorios_print.css", "media" => "print");

    if (isset($_GET['SCT_ID'])) {
        $SNCTID = $_GET['SCT_ID'];
    }
    ?>

    <script type="text/javascript">
        function lock()
        {
            document.getElementById('l1').disabled = true;
            document.getElementById('l2').disabled = true;
            document.getElementById('l3').disabled = true;
            document.getElementById('ll1').style.color = '#959595';
            document.getElementById('ll2').style.color = '#959595';
            document.getElementById('ll3').style.color = '#959595';
        }

        function unlock()
        {
            document.getElementById('l1').disabled = false;
            document.getElementById('l2').disabled = false;
            document.getElementById('l3').disabled = false;
            document.getElementById('ll1').style.color = '#000000';
            document.getElementById('ll2').style.color = '#000000';
            document.getElementById('ll3').style.color = '#000000';
        }
    </script>


    <h1 style="margin-bottom:30px;" class="noprint">RELATÓRIOS DE INSCRIÇÕES</h1>

    <div id="relatorios">
        <form method="post" action="<?php echo $Esta_Pagina ?>">
            <label for="l1" style="margin-right:30px;">LISTAR:</label><br/>
            <hr style="border:1px #a5a5a5 dashed;margin:15px 0px;" />
            <input type="hidden" name="listar" id="l1" value="0" <?php echo $listar == 0 ? 'checked="checked" ' : '' ?>/><!--<font id="ll1">TODOS OS USUÁRIOS</font>
            <input type="radio" name="listar" id="l2" value="1" style="margin-left:40px;" <?php echo $listar == 1 ? 'checked="checked" ' : '' ?>/><font id="ll2">APENAS ALUNOS</font>
            <input type="radio" name="listar" id="l3" value="2" style="margin-left:40px;" <?php echo $listar == 2 ? 'checked="checked" ' : '' ?>/><font id="ll3">NÃO ALUNOS</font>-->
            <input type="radio" name="opcao" value="1" <?php echo $opcao == 1 ? 'checked="checked" ' : 'checked="checked' ?>onclick="unlock();" />USUÁRIOS CADASTRADOS.<br/><br/>
            FILTRAR POR DOCUMENTO OU NOME: 	    <input type="text" name="busca" value="<?php echo $opcao == 2 ? '' : $busca ?>"/>
            <hr style="border:1px #a5a5a5 dashed;margin:15px 0px;" />
            <input type="radio" name="opcao" value="2" <?php echo $opcao == 2 ? 'checked="checked" ' : '' ?>onclick="unlock();" />USUÁRIOS INSCRITOS POR EVENTO:
            <select name="evento_op2" style="width:650px; height: 20px">
                <?php
                $query = "SELECT * FROM eventos WHERE tipo<>'0' AND semtec='{$SNCTID}' ORDER BY id";
                $result = $DB->Query($query);
                if (@mysql_num_rows($result) <= 0):
                    echo "<option value=\"0\"><i>Nenhum evento encontrado</i></option>";
                else:
                    while ($x = mysql_fetch_array($result)):
                        ?>

                        <option value="<?php echo $x['id'] ?>" <?php echo $evento_op2 == $x['id'] ? 'selected="selected"' : '' ?>><?php echo $x['id'] ?> - <?php echo $x['titulo'] ?></option>
                        <?php
                    endwhile;
                endif;
                ?>
            </select><br/><br/>

            <hr style="border:1px #a5a5a5 dashed;margin:15px 0px;" />






            <input type="submit" value="Exibir relatório" />
        </form>
    </div>

    <?php
    require_once("relatorios_functions.php");

    if ($opcao == 1):
        busca_usuario($busca);
    elseif ($opcao == 2):
        usuarios_por_evento($evento_op2, $listar);
    elseif ($opcao == 3):
        busca_usuario($busca);
    endif;
    ?>
<?php } ?>
