<?php
# $listar = 0=>Todos | 1=>Alunos | 2=>Não alunos #

$_arraySearch = array('á', 'é', 'í', 'ó', 'ú', 'ã', 'õ', 'â', 'ê', 'ô', 'ç');
$_arrayReplace = array('Á', 'É', 'Í', 'Ó', 'Ú', 'Ã', 'Õ', 'Â', 'Ê', 'Ô', 'Ç');

function usuarios_por_evento($evento_id, $listar) {
    global $_arraySearch, $_arrayReplace, $DB, $CONFIG;
    ?>

    <?
    $query = "SELECT titulo FROM eventos WHERE id='$evento_id'";
    $Revento = mysql_fetch_array($DB->Query($query));
    $query = "SELECT * FROM participantes p, participacoes t WHERE t.cpf_participante = p.cpf AND t.id_evento='$evento_id' AND t.tipo='P' ";
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

        <? $Revento['titulo'] = str_replace($_arraySearch, $_arrayReplace, strtoupper($Revento['titulo'])); ?>
        <b>EVENTO: <i><?= $Revento['titulo'] ?></i> (<?= mysql_num_rows($result) ?>)</b>
        <br/>

        <form name="presenca" method="post" action="<?= $Esta_Pagina ?>" onsubmit="document.getElementById('Psubmit').disabled = true;">
            <input type="hidden" name="evento" value="<?= $evento_id ?>" />
            <input type="hidden" name="listar" value="<?= $listar ?>" />

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

                    <th align="center" width="100">PRESENÇA</th>
                </tr>

                <?
                while ($x = mysql_fetch_array($result)):
                    $x['nome'] = str_replace($_arraySearch, $_arrayReplace, strtoupper($x['nome']));
                    ?>

                    <tr>
                        <td><?= $x['nome'] ?></td>

                        <? if ($listar == 1): ?>
                            <td align="center"><?= strlen($x['RA']) ? substr($x['RA'], 0, 6) . "-" . strtoupper(substr($x['RA'], 6, 1)) : "<b>-------</b>" ?></td>
                        <? else: ?>
                            <td align="center"><? echo $x['cpf'] ?></td>
                        <? endif ?>

                        <td align="center">
                            <input type="checkbox" name="cbx[<?= $x['cpf'] ?>]" <?= $x['presenca'] == 1 ? 'checked="checked"' : '' ?> onclick="set_presenca('p_<?= $x['cpf'] ?>');" class="noprint" />
                            <input type="hidden" name="presenca[<?= $x['cpf'] ?>]" id="p_<?= $x['cpf'] ?>" value="<?= $x['presenca'] ?>" />
                            <b style="color:#<?= $x['presenca'] == 1 ? '00c400' : 'f00' ?>" class="noshow"><?= $x['presenca'] == 1 ? 'OK' : 'FALTA' ?></b>
                        </td>
                    </tr>

                <? endwhile ?>

            </table>

            <br class="noprint"/>
            <input type="submit" value="Confirmar" id="Psubmit" class="noprint" style="float:right;" />
        </form>

    <? endif ?>
    <?
}

//function usuarios_por_evento()

function turmas_por_evento($evento_id, $listar) {
    global $_arraySearch, $_arrayReplace, $DB, $CONFIG;
    include("630.php");
    include("631.php");
    include("632.php");
    include("633.php");
    include("634.php");
    include("635.php");
    include("636.php");
    ?>

    <form name="presenca" method="post" action="<?= $Esta_Pagina ?>" onsubmit="document.getElementById('Psubmit').disabled = true;">
        <input type="hidden" name="evento" value="<?= $evento_id ?>" />
        <input type="hidden" name="listar" value="<?= $listar ?>" />

        <?
        $query = "SELECT titulo FROM eventos WHERE id='$evento_id'";
        $Revento = mysql_fetch_array($DB->Query($query));

        $total = count($T_array);
        foreach ($T_array as $turma => $alunos):
            $count++;
            $query = "SELECT * FROM participantes p, participacoes t WHERE t.cpf_participante = p.cpf AND t.id_evento='$evento_id' AND t.tipo='M' AND p.RA IN (";

            foreach ($alunos as $prontuario) {
                $query .= "'$prontuario',";
            }

            $query = substr($query, 0, -1);
            $query .= ") ORDER BY p.nome";
            //exit($query);
            $result = $DB->Query($query);
            if (@mysql_num_rows($result) <= 0):
                echo "<i>Nenhuma inscrição para este evento na turma $turma.</i><br/><br/>";
            else:
                ?>

                <? $Revento['titulo'] = str_replace($_arraySearch, $_arrayReplace, strtoupper($Revento['titulo'])); ?>
                <b>EVENTO: <i><?= $Revento['titulo'] ?></i> (<?= mysql_num_rows($result) ?>)</b><br/>
                <b>TURMA: &nbsp;&nbsp;<?= $turma ?></b>
                <br/><br class="noshow"/>

                <table cellspacing="0"<? if ($count < $total): ?> style="page-break-after:always;"<? endif ?>>
                    <? if ($count == 1): ?>
                        <caption class="noprint" style="text-align:right;padding:5px">
                            <a href="javascript:void();" onclick="window.print();" title="imprimir"><img src="<?php echo $CONFIG->URL_ROOT ?>/includes/imgs/print.png" alt="imprimir" /></a>
                        </caption>
                    <? endif ?>
                    <tr>
                        <th>NOME</th>
                        <th align="center">PRONTUÁRIO</th>
                        <th align="center" width="100">PRESENÇA</th>
                    </tr>

                    <?
                    while ($x = mysql_fetch_array($result)):
                        $x['nome'] = str_replace($_arraySearch, $_arrayReplace, strtoupper($x['nome']));
                        ?>

                        <tr>
                            <td><?= $x['nome'] ?></td>
                            <td align="center"><?= strlen($x['RA']) ? substr($x['RA'], 0, 6) . "-" . strtoupper(substr($x['RA'], 6, 1)) : "<b>-------</b>" ?></td>
                            <td align="center">
                                <input type="checkbox" name="cbx[<?= $x['cpf'] ?>]" <?= $x['presenca'] == 1 ? 'checked="checked"' : '' ?> onclick="set_presenca('p_<?= $x['cpf'] ?>');" class="noprint" />
                                <input type="hidden" name="presenca[<?= $x['cpf'] ?>]" id="p_<?= $x['cpf'] ?>" value="<?= $x['presenca'] ?>" />
                                <b style="color:#<?= $x['presenca'] == 1 ? '00c400' : 'f00' ?>" class="noshow"><?= $x['presenca'] == 1 ? 'OK' : 'FALTA' ?></b>
                            </td>
                        </tr>

                    <? endwhile ?>

                </table>
                <br class="noprint" />
                <br class="noprint" />

            <? endif ?>
        <? endforeach ?>

        <br class="noprint"/>
        <input type="submit" value="Confirmar" id="Psubmit" class="noprint" style="float:right;" />
    </form>
    <?
}

//function turmas_por_evento()
?>