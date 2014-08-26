<?php
if (tipoadmin(3, $USER->getCpf(), $SCT_ID)) {
    $SNCTID = $SCT_ID; //SCT_ID;
# ----------------------- Parâmetros GET/POST ----------------------------- #
    $listar = safe_sql($_REQUEST['listar']);
    $listar = (empty($listar) || $listar < 0 || $listar > 3) ? 0 : $listar;
    $evento = safe_sql($_REQUEST['evento']);
# ------------------------------------------------------------------------- #
# ------------------------- Registra Presença ----------------------------- #
    if (isset($_POST['presenca'])):
        //echo "<pre>"; print_r($_POST); echo "</pre>"; exit;
        $presenca = safe_sql($_POST['presenca']);
        $nok = 0;
        foreach ($presenca as $cpf => $status) {
            $status = $status == 1 ? 1 : 0;
            $query = "UPDATE participacoes SET presenca='$status' WHERE cpf_participante='$cpf' AND id_evento='$evento'";
            $nok = $DB->Query($query) ? $nok : $nok + 1;
        }
    endif;
# ------------------------------------------------------------------------- #

    $header['css'][] = array("href" => $CONFIG->URL_ROOT . "/templates/" . $EVENTO['TEMPLATE'] . "/css/presenca.css", "media" => "screen");
    $header['css'][] = array("href" => $CONFIG->URL_ROOT . "/templates/" . $EVENTO['TEMPLATE'] . "/css/relatorios_print.css", "media" => "print");

    if (isset($_GET['SCT_ID'])) {
        $SNCTID = $_GET['SCT_ID'];
    }
    ?>

    <script type="text/javascript">
        function set_presenca(id_cpf)
        {
            var status = document.getElementById(id_cpf).value;
            status = parseInt(status);

            if (status == 1) {
                document.getElementById(id_cpf).value = 0;
            } else {
                document.getElementById(id_cpf).value = 1;
            }
            //alert(document.getElementById(id_cpf).value);
        }
    </script>


    <h1 style="margin-bottom:30px;" class="noprint">LISTA DE PRESENÇA</h1>

    <?php if ($nok > 0): ?>
        <span class="noprint">Ocorreram <b><?php echo $nok ?></b> erros.</span>
    <?php endif ?>

    <div id="relatorios">
        <form method="post" action="<?php echo $Esta_Pagina ?>">
            <input type="hidden" name="listar" id="l1" value="0" <?php echo $listar == 0 ? 'checked="checked" ' : '' ?>/>
            <!--<label for="l1" style="margin-right:30px;">LISTAR:</label>
            <font id="ll1">TODOS OS USUÁRIOS</font>
            <input type="radio" name="listar" id="l2" value="1" style="margin-left:40px;" <?php echo $listar == 1 ? 'checked="checked" ' : '' ?>/><font id="ll2">APENAS ALUNOS</font>
                                                <br/>
            <input type="radio" name="listar" id="l3" value="2" style="margin-left:95px;margin-top:10px;//margin-left:91px;" <?php echo $listar == 2 ? 'checked="checked" ' : '' ?>/><font id="ll3">NÃO ALUNOS</font> -->
            <!--input type="radio" name="opcao" value="1" checked="checked" /-->EVENTO:
            <select name="evento" style="width:650px; height: 20px">
                <?php
                $query = "SELECT * FROM eventos WHERE tipo<>'0' AND semtec='{$SNCTID}' ORDER BY id";
                $result = $DB->Query($query);
                if (@mysql_num_rows($result) <= 0):
                    echo "<option value=\"0\"><i>Nenhum evento encontrado</i></option>";
                else:
                    while ($x = mysql_fetch_array($result)):
                        ?>

                        <option value="<?php echo $x['id'] ?>" <?php echo $evento == $x['id'] ? 'selected="selected"' : '' ?>><?php echo $x['id'] ?> - <?php echo $x['titulo'] ?></option>
                        <?php
                    endwhile;
                endif;
                ?>
            </select>
            <hr style="border:1px #a5a5a5 dashed;margin:15px 0px;" />
            <input type="submit" value="Exibir lista" />
        </form>
    </div>

    <?php
    require_once("presenca_functions.php");

    if ($listar >= 0 && $listar <= 2):
        usuarios_por_evento($evento, $listar);
    endif;
    ?>
<?php } ?>