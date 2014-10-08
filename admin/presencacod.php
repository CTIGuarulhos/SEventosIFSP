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
//Apenas para controle de exibição
    $primeiro = true;



//$header['css'][] = array("href"=>CSS_DIR."/programacao.css", "media"=>"all");
    ?>
    <h1>Presença atraves de Código de Barras ou Código de Usuário<span class="imgH1 geral"></span></h1>
    <br/>

    <p>
        Insira os dados abaixo<br><br>
        <?php if (isset($_GET['evento']) && ($_GET['evento'] != "")) { ?>
            <?php
            $query = "SELECT titulo, data, hora FROM eventos WHERE id='{$_GET['evento']}'";
            $dataevento = $DB->Query($query);
            if (@mysql_num_rows($dataevento) > 0):  //if 01
                while ($datetime = mysql_fetch_array($dataevento)):
                    if (($datetime['data'] != "") && ($datetime['hora'] != "")) {
                        $data = $datetime['data'];
                        $hora = $datetime['hora'];
                        $titulo = $datetime['titulo'];
                    }
                endwhile;
                $ini_time = strtotime("$data $hora");
                $lib_time = strtotime("$data $hora -{$EVENTO['LIBERACAO']} minutes");
                $ini_evento = date('d/m/Y H:i:s', $ini_time);
                $lib_evento = date('d/m/Y H:i:s', $lib_time);
                ?>
                Nome do evento: <?php echo $titulo ?><br>
                Inicio do evento: <?php echo $ini_evento ?><br>
                Liberação para fila de espera: <?php echo $lib_evento ?><br><br>
                <?php
                if (time() > $lib_time) {
                    echo "<font color='green'><b>Liberado para fila de espera</b></font>";
                } else {
                    echo "<font color='red'><b>Liberado apenas para participantes inscritos</b></font>";
                }
                ?><br>



            <?php endif; ?>
        <?php } ?>

    </p>



    <?php if (isset($_GET['evento']) && ($_GET['evento'] != "")) { ?>

        <?php
        if (isset($_POST['presenca_evento'])):

            //Escapa as variÃveis
            $_POST = safe_sql($_POST);

            //Transforma os parametros em variaveis
            extract($_POST, EXTR_PREFIX_SAME, "");
            $dadosOK = true;

            //Valida se existe participante
            $query = "SELECT cpf FROM participantes WHERE cpf='{$_POST['cpf']}'";
            $participante = $DB->Query($query);
            if (@mysql_num_rows($participante) == 0):  //if 01
                $dadosOK = false;
                $erro['insert'] = "Participante Inexistente.";
            endif;

            if ($dadosOK) {
                $query = "SELECT cpf_participante, id_evento  FROM participacoes WHERE cpf_participante='{$_POST['cpf']}' AND id_evento='{$_GET['evento']}'";
                $cpf_evento = $DB->Query($query);
                if (@mysql_num_rows($cpf_evento) > 0):  //if 01
                    if (@mysql_num_rows($cpf_evento) == 1):  //if 01 
                        $query = "UPDATE participacoes SET presenca='1' ";
                        $query .= "WHERE cpf_participante='{$_POST['cpf']}' AND id_evento='{$_GET['evento']}'";
                        //echo $query;
                        //exit($query);
                        if (!$DB->Query($query)) {
                            $dadosOK = false;
                            $erro['insert'] = "Erro ao inserir no banco de dados.";
                        }
                        ?>
                    <?php endif;
                    ?>

                <?php else: ?>
                    <?php
                    if (time() > $lib_time) {
                        $query = "INSERT INTO participacoes(cpf_participante,id_evento,tipo,data_inscricao,presenca,data_visualizacao) ";
                        $query .= "VALUES('{$_POST['cpf']}','{$_GET['evento']}','P','NULL','1','NULL')";
                        //echo $query;
                        //exit($query);
                        if (!$DB->Query($query)) {
                            $dadosOK = false;
                            $erro['insert'] = "Erro ao inserir no banco de dados.";
                        }
                    } else {
                        $dadosOK = false;
                        $erro['insert'] = "Usuário deverá ir para fila de espera.";
                    }
                    ?>
                <?php
                endif;
            }
            ?>
            <?php
        endif;
#---------------------------------------------------------------------------#
//$query = "SELECT * FROM `eventos` WHERE `id` = '$editevento'";
//$result = mysql_fetch_array($DB->Query($query));
        ?>

        <?php
//Mensagem de erro (se houver)
        if (isset($dadosOK) && !$dadosOK)
            HTML_ErrorMessage($erro);
//Mensagem de atualizaÃ§Ã£o OK
        if (isset($dadosOK) && $dadosOK)
            HTML_SuccessMessage("Seus dados foram inseridos com sucesso.");
        ?>

        <form class="forms" name="presenca_evento" method="post" action="<?php echo $Esta_Pagina ?>">

            <input type="hidden" name="presenca_evento" value="false" />

            <!--		<label for="id">
            <?php HTML_RequiredField() ?>ID do evento: (apenas números)
            </label>
            <input type="text" name="id" id="id" maxlength="4" size="35" value="<?php echo $result['id'] ?>" disabled="disabled" />
            <br/><br/> -->
            <label for="cpf"><?php HTML_RequiredField() ?>Código:</label>
            <input type="text" name="cpf" id="cpf" maxlength="15" size="35" />
            <br/><br/>
            <input type="submit" value="Inserir Participação" />
            <br><br>
            <input type="BUTTON" value="Selecionar outro evento" onclick="location.href = '<?php echo $CONFIG->URL_ROOT ?>/?pag=<?php echo $_GET['pag']; ?><?php
            if (isset($_GET['SCT'])) {
                echo '&SCT=' . $_GET['SCT'];
            }
            ?>'">
        </form>
        <br>
        <script
            type = "text/javascript"
            language = "javascript" >
                document.getElementById("cpf").focus();
        </script>

        <?php
        $query = "SELECT titulo FROM eventos WHERE id='{$_GET['evento']}'";
        $Revento = mysql_fetch_array($DB->Query($query));
        $query = "SELECT * FROM participantes p, participacoes t WHERE t.cpf_participante = p.cpf AND t.id_evento='{$_GET['evento']}' AND t.tipo='P' AND presenca='1' ";
        $query .= "ORDER BY p.nome";
        $result = $DB->Query($query);
        if (@mysql_num_rows($result) <= 0):
            echo "<i>Nenhuma inscrição para este evento.</i>";
        else:
            ?>

            <br/>
            <h4>Presenças Confirmadas (<?php echo mysql_num_rows($result) ?>)</h4>
            <br/>
            <table width="100%" border="0">
                <tr>
                    <th>NOME</th>
                    <th align="center">DOCUMENTO</th>
                </tr>
                <?php
                while ($x = mysql_fetch_array($result)):
                    $x['nome'] = str_replace($_arraySearch, $_arrayReplace, strtoupper($x['nome']));
                    ?>

                    <tr>
                        <td align="center"><?php echo $x['nome'] ?></td>
                        <td align="center"><?php echo $x['cpf'] ?></td>
                    </tr>

                <?php endwhile ?>

            </table>
        <?php endif ?>

        <br/><br/>
    <?php } else { ?>
        <form class="forms" name="seleciona_evento" method="get" action="<?php echo $Esta_Pagina ?>">
            <INPUT TYPE="hidden" NAME="pag" VALUE="<?php echo $_GET['pag']; ?>">
            <INPUT TYPE="hidden" NAME="SCT" VALUE="<?php echo $_GET['SCT']; ?>">
            <label for="evento"><?php HTML_RequiredField() ?>Evento:</label>


            <select name="evento" style="width:650px; height: 20px">
                <?php
                $query = "SELECT * FROM eventos WHERE tipo<>'0' AND semtec='{$SNCTID}' ORDER BY id";
                $result = $DB->Query($query);
                if (@mysql_num_rows($result) <= 0):
                    echo "<option value=\"0\"><i>Nenhum evento encontrado</i></option>";
                else:
                    echo "<option value=\"\" selected><i>**Selecione**</i></option>";
                    while ($x = mysql_fetch_array($result)):
                        ?>

                        <option value="<?php echo $x['id'] ?>" <?php echo $evento_op2 == $x['id'] ? 'selected="selected"' : '' ?>><?php echo $x['id'] ?> - <?php echo $x['titulo'] ?></option>
                        <?php
                    endwhile;
                endif;
                ?>

            </select>
                <!--<input type="text" name="evento" id="evento" maxlength="5" size="35" /> -->
            <br/><br/>	

            <input type="submit" value="Selecionar Evento" />
        </form>

        <?php
    }
    ?>
<?php } ?>
