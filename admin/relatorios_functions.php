<?php
# $listar = 0=>Todos | 1=>Alunos | 2=>N�o alunos #

$_arraySearch = array('á', 'é', 'í', 'ó', 'ú', 'ã', 'õ', 'â', 'ê', 'ô', 'ç');
$_arrayReplace = array('Á', 'É', 'Í', 'Ó', 'Ú', 'Ã', 'Õ', 'Â', 'Ê', 'Ô', 'Ç');

function usuarios_inscritos($listar) {
    global $_arraySearch, $_arrayReplace, $DB, $CONFIG;
    ?>

    <?
    if ($listar == 1)
        $query = "SELECT * FROM participantes WHERE RA IS NOT NULL AND cpf NOT IN('24985405809','16719501860') AND CONFIRMADO = '1'  ORDER BY nome";
    elseif ($listar == 2)
        $query = "SELECT * FROM participantes WHERE RA IS NULL AND cpf NOT IN('24985405809','16719501860') AND CONFIRMADO = '1' ORDER BY nome";
    else
        $query = "SELECT * FROM participantes WHERE cpf NOT IN('24985405809','16719501860') AND CONFIRMADO = '1'  ORDER BY nome";

    $result = $DB->Query($query);
    if (@mysql_num_rows($result) <= 0):
        echo "<i>Nenhum usuário cadastrado.</i>";
    else:
        ?>

        <b>USUÁRIOS INSCRITOS: (<?= mysql_num_rows($result) ?>)</b>
        <br/><br class="noshow"/>

        <table cellspacing="0">
            <caption class="noprint" style="text-align:right;padding:5px">
                <a href="javascript:void();" onclick="window.print();" title="imprimir"><img src="<?php echo $CONFIG->URL_ROOT ?>/includes/imgs/print.png" alt="imprimir" /></a>
            </caption>
            <tr>
                <th>NOME</th>

                <? if ($listar == 1): ?>
                    <th align="center">PRONTUÁRIO</th>
                <? else: ?>
                    <th align="center">DOCUMENTO</th>
                <? endif ?>

                <th align="center" width="200">ASSINATURA</th>
            </tr>

            <?
            while ($x = mysql_fetch_array($result)):
                $x['nome'] = str_replace($_arraySearch, $_arrayReplace, strtoupper($x['nome']));
                ?>

                <tr>
                    <td><a href="javascript:void();" onclick="AbreCracha('<?php echo $CONFIG->URL_ROOT ?>/admin/cracha/?nome=<?= $x['nome'] ?>&instituicao=Visitante&tipoParticipante=<?= $x['cpf'] ?>&print=1');"><font color="black"><?= $x['nome'] ?></font></a></td>

                    <? if ($listar == 1): ?>
                        <td align="center"><?= strlen($x['RA']) ? substr($x['RA'], 0, 6) . "-" . strtoupper(substr($x['RA'], 6, 1)) : "<b>-------</b>" ?></td>
                    <? else: ?>
                        <td align="center"><?= $x['cpf'] ?></td>
                    <? endif ?>

                    <td>&nbsp;</td>
                </tr>

            <? endwhile ?>



        </table>

    <? endif ?>
    <?
}

//function usuarios_inscritos()

function busca_usuario($busca) {
    global $_arraySearch, $_arrayReplace, $DB, $CONFIG;
    ?>

    <?
    $busca = str_replace(".", "", $busca);

    //if ($busca <> "")
    $query = "SELECT * FROM participantes WHERE cpf NOT IN('24985405809','16719501860') AND (NOME LIKE '%$busca%' OR CPF LIKE '%$busca%' OR RG LIKE '%$busca%') ORDER BY nome";

    $result = $DB->Query($query);
    if (@mysql_num_rows($result) <= 0):
        //if ($busca <> "")
        echo "<i>Nenhum usuário encontrado.</i>";
    //else
    //	echo "<i>Você precisa preencher com um nome ou documento para Buscar.</i>";
    else:
        ?>

        <b>USUÁRIOS ENCONTRADOS: (<?= mysql_num_rows($result) ?>)</b>
        <br/><br class="noshow"/>

        <table cellspacing="0">
            <caption class="noprint" style="text-align:right;padding:5px">
                <a href="javascript:void();" onclick="window.print();" title="imprimir"><img src="<?php echo $CONFIG->URL_ROOT ?>/includes/imgs/print.png" alt="imprimir" /></a>
            </caption>
            <tr>
                <th>NOME</th>

                <? if ($listar == 1): ?>
                    <th align="center">PRONTUÁRIO</th>
                <? else: ?>
                    <th align="center">DOCUMENTO</th>
                <? endif ?>

                <th align="center" width="200">ASSINATURA</th>
            </tr>

            <?
            while ($x = mysql_fetch_array($result)):
                $x['nome'] = str_replace($_arraySearch, $_arrayReplace, strtoupper($x['nome']));
                ?>

                <tr>
                    <td><a href="javascript:void();" onclick="AbreCracha('<?php echo $CONFIG->URL_ROOT ?>/admin/cracha/?nome=<?= $x['nome'] ?>&instituicao=Visitante&tipoParticipante=<?= $x['cpf'] ?>&print=1');"><font color="black"><?= $x['nome'] ?></font></a></td>

                    <? if ($listar == 1): ?>
                        <td align="center"><?= strlen($x['RA']) ? substr($x['RA'], 0, 6) . "-" . strtoupper(substr($x['RA'], 6, 1)) : "<b>-------</b>" ?></td>
                    <? else: ?>
                        <td align="center"><?= substr($x['cpf'], 0, 3) . "." . substr($x['cpf'], 3, 3) . "." . substr($x['cpf'], 6, 3) . "-" . substr($x['cpf'], 9, 2) ?></td>
                    <? endif ?>

                    <td>&nbsp;</td>
                </tr>

            <? endwhile ?>



        </table>

    <? endif ?>
    <?
}

//function usuarios_inscritos()

function usuarios_por_evento($evento_id, $listar) {
    global $_arraySearch, $_arrayReplace, $CONFIG, $DB;
    ?>

    <?
    $query = "SELECT * FROM eventos WHERE id='$evento_id'";
    $Revento = mysql_fetch_array($DB->Query($query));
    $query = "SELECT * FROM participantes p, participacoes t WHERE t.cpf_participante = p.cpf AND t.id_evento='$evento_id' ";
    if ($listar == 1)
        $query .= "AND p.RA IS NOT NULL ";
    elseif ($listar == 2)
        $query .= "AND p.RA IS NULL ";
    $query .= "ORDER BY p.nome";
    $result = $DB->Query($query);
    if (@mysql_num_rows($result) <= 0):
        echo "<i>Nenhuma inscrição para este evento.</i>";
    else:
        ?>

        <?
        $Revento['titulo'] = str_replace($_arraySearch, $_arrayReplace, strtoupper($Revento['titulo']));
        $dt = date_create($Revento['data']);         //datetime
        $data_evento = date_format($dt, "d/m/Y");   //string - data do evento
        $hora_evento = substr($Revento['hora'], 0, 5); //string - hora do evento 
        ?>
        <b>EVENTO <?= $Revento['id'] ?>: <i><?= $Revento['titulo'] ?></i> (<?= mysql_num_rows($result) ?>/<?= $Revento['vagas'] ?>)</b><br>Local: <?= $Revento['local'] ?><br>Data: <?= $data_evento ?>&nbsp;&nbsp;<b>|</b>&nbsp;&nbsp;Horário: <?= $hora_evento ?>&nbsp;&nbsp;<b>|</b>&nbsp;&nbsp;Duração aprox.: <?= $Revento['duracao'] ?> min.
        <br/><br class="noshow"/>

        <table cellspacing="0">
            <caption class="noprint" style="text-align:right;padding:5px">
                <a href="javascript:void();" onclick="window.print();" title="imprimir"><img src="<?php echo $CONFIG->URL_ROOT ?>/includes/imgs/print.png" alt="imprimir" /></a>
            </caption>
            <tr>
                <th>NOME</th>

                <? if ($listar == 1): ?>
                    <th align="center">PRONTUÁRIO</th>
                <? else: ?>
                    <th align="center">DOCUMENTO</th>
                <? endif ?>

                <th align="center" width="200">ASSINATURA</th>
            </tr>

            <?
            while ($x = mysql_fetch_array($result)):
                $x['nome'] = str_replace($_arraySearch, $_arrayReplace, strtoupper($x['nome']));
                if ($listar == 2) {
                    $x['inst_empresa'] = str_replace($_arraySearch, $_arrayReplace, strtoupper($x['inst_empresa']));
                }
                ?>

                <tr>

                    <td><a href="javascript:void();" onclick="AbreCracha('<?php echo $CONFIG->URL_ROOT ?>/admin/cracha/?nome=<?= $x['nome'] ?>&instituicao=Visitante&tipoParticipante=<?= $x['cpf'] ?>&print=1');"><font color="black"><?= $x['nome'] ?></font></a></td>

                    <? if ($listar == 1): ?>
                        <td align="center"><?= strlen($x['RA']) ? substr($x['RA'], 0, 6) . "-" . strtoupper(substr($x['RA'], 6, 1)) : "<b>-------</b>" ?></td>
                    <? else: ?>
                        <td align="center"><?= $x['cpf'] ?></td>
                    <? endif ?>

                    <td>&nbsp;</td>
                </tr>

            <? endwhile ?>

            <? $linhasvazias = 0 ?>
            <? while ($linhasvazias < 10): ?> 
                <? $linhasvazias = $linhasvazias + 1; ?>
                <tr>
                    <td><font color='white'><? echo $linhasvazias; ?></font></td>

                    <? if ($listar == 1): ?>
                        <td align="center"></td>
                    <? else: ?>
                        <td align="center"></td>
                    <? endif ?>

                    <td align="center" width="200"></td>
                </tr>
            <? endwhile ?>
        </table>

    <? endif ?>
    <?
}

//function usuarios_por_evento()
?>
