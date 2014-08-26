<?php
# $listar = 0=>Todos | 1=>Alunos | 2=>N�o alunos #

$_arraySearch = array('á', 'é', 'í', 'ó', 'ú', 'ã', 'õ', 'â', 'ê', 'ô', 'ç');
$_arrayReplace = array('Á', 'É', 'Í', 'Ó', 'Ú', 'Ã', 'Õ', 'Â', 'Ê', 'Ô', 'Ç');

function deletar_usuario($usuarioadeletar) {
    global $_arraySearch, $_arrayReplace, $DB, $CONFIG;
    $query = "DELETE FROM participantes WHERE CPF = '$usuarioadeletar';";
    $result = $DB->Query($query);
}

function usuarios_inscritos($listar) {
    global $_arraySearch, $_arrayReplace, $DB, $CONFIG;
    ?>

    <?php
    if ($listar == 1)
        $query = "SELECT * FROM participantes WHERE cpf NOT IN('24985405809','16719501860') AND confirmado = 0 ORDER BY nome";
    elseif ($listar == 2)
        $query = "SELECT * FROM participantes WHERE cpf NOT IN('24985405809','16719501860') AND confirmado = 1 ORDER BY nome";
    $result = $DB->Query($query);
    if (@mysql_num_rows($result) <= 0):
        echo "<i>Nenhum usuário cadastrado.</i>";
    else:
        ?>

        <b>ALUNOS <?php if ($listar == 1): ?>NÃO <?php endif ?>ATIVOS: (<?php echo mysql_num_rows($result) ?>)</b>
        <br/><br class="noshow"/>

        <table cellspacing="0">
            <caption class="noprint" style="text-align:right;padding:5px">
                <a href="javascript:void();" onclick="window.print();" title="imprimir"><img src="<?php echo $CONFIG->URL_ROOT ?>/includes/imgs/print.png" alt="imprimir" /></a>
            </caption>
            <tr>
                <th>NOME</th>
                <th>E-MAIL</th>
                <th>DOCUMENTO</th>
                <th>AÇÕES</th>
            </tr>

            <?php
            while ($x = mysql_fetch_array($result)):
                $x['nome'] = str_replace($_arraySearch, $_arrayReplace, strtoupper($x['nome']));
                ?>

                <tr>
                    <td><?php echo $x['nome'] ?></td>
                    <td><?php echo strtolower($x['email']) ?></td>	
                    <td align="center"><?php echo $x['cpf'] ?></td>
                <form method="post" action="<?php echo $Esta_Pagina ?>">
                    <td align="center">
                        <a href='<?php echo $CONFIG->URL_ROOT ?>/?pag=admusuarioedit&usuario=<?php echo $x['cpf'] ?>' ALT="EDITAR" title="EDITAR"><img src="<?php echo $CONFIG->URL_ROOT ?>/includes/imgs/view.png" width="14" height="12" ALT="EDITAR" title="EDITAR"></a> &nbsp;&nbsp;
                        <input type="hidden" name="deletarusuario" value="<?php echo $x['cpf'] ?>" />
                        <input type="image" src="<?php echo $CONFIG->URL_ROOT ?>/includes/imgs/deletar.gif" width="11" height="11" name="DELETAR" ALT="DELETAR" VALUE="DELETAR" title="DELETAR">
                </form>

            </td>
            </tr>

        <?php endwhile ?>

        </table>

    <?php endif ?>
    <?php
}

//function usuarios_inscritos()


function buscar_usuarios($listar, $busca) {
    global $_arraySearch, $_arrayReplace, $DB, $CONFIG;
    ?>

    <?php
    $query = "SELECT * FROM participantes WHERE cpf NOT IN('24985405809','16719501860') AND (NOME LIKE '%$busca%' OR CPF LIKE '%$busca%' OR RG LIKE '%$busca%') ";
    if ($listar == "1") {
        $query .= "AND confirmado='0'";
    } elseif ($listar == "2") {
        $query .= "AND confirmado='1'";
    }
    $query .= " ORDER BY nome";
    $result = $DB->Query($query);
    if (@mysql_num_rows($result) <= 0):
        echo "<i>Nenhum usuário cadastrado.</i>";
    else:
        ?>
        <?php if ($busca != '') : ?>
            <b>BUSCA "<?php echo $busca; ?>" EM <?php if ($listar == '0'): ?>TODOS OS USUARIOS<?php endif ?><?php if ($listar == 1): ?>USUÁRIOS NÃO ATIVOS<?php endif ?><?php if ($listar == 2): ?>USUÁRIOS ATIVOS<?php endif ?>: (<?php echo mysql_num_rows($result) ?>)</b><?php else: ?>
            <b>EXIBINDO <?php if ($listar == '0'): ?>TODOS OS USUARIOS<?php endif ?><?php if ($listar == 1): ?>USUÁRIOS NÃO ATIVOS<?php endif ?><?php if ($listar == 2): ?>USUÁRIOS ATIVOS<?php endif ?>: (<?php echo mysql_num_rows($result) ?>)</b><?php endif; ?>
        <br/><br class="noshow"/>

        <table cellspacing="0">
            <caption class="noprint" style="text-align:right;padding:5px">
                <a href="javascript:void();" onclick="window.print();" title="imprimir"><img src="<?php echo $CONFIG->URL_ROOT ?>/includes/imgs/print.png" alt="imprimir" /></a>
            </caption>
            <tr>
                <th>NOME</th>
                <th>E-MAIL</th>
                <th>DOCUMENTO</th>
                <th>AÇÕES</th>
            </tr>

            <?php
            while ($x = mysql_fetch_array($result)):
                $x['nome'] = str_replace($_arraySearch, $_arrayReplace, strtoupper($x['nome']));
                ?>

                <tr>
                    <td><?php echo $x['nome'] ?></td>
                    <td><?php echo strtolower($x['email']) ?></td>	
                    <td align="center"><?php echo $x['cpf'] ?></td>
                <form method="post" action="<?php echo $Esta_Pagina ?>">
                    <td align="center">
                        <a href='<?php echo $CONFIG->URL_ROOT ?>/?pag=admusuarioedit&usuario=<?php echo $x['cpf'] ?><?php
                        if (isset($_GET['SCT'])) {
                            echo '&SCT=' . $_GET['SCT'];
                        }
                        ?>' ALT="EDITAR" title="EDITAR"><img src="<?php echo $CONFIG->URL_ROOT ?>/includes/imgs/view.png" width="14" height="12" ALT="EDITAR" title="EDITAR"></a> &nbsp;&nbsp;
                        <input type="hidden" name="deletarusuario" value="<?php echo $x['cpf'] ?>" />
                        <input type="image" src="<?php echo $CONFIG->URL_ROOT ?>/includes/imgs/deletar.gif" width="11" height="11" name="DELETAR" ALT="DELETAR" VALUE="DELETAR" title="DELETAR">
                </form>

            </td>
            </tr>

        <?php endwhile ?>

        </table>

    <?php endif ?>
    <?php
}

//function usuarios_inscritos()
?>
