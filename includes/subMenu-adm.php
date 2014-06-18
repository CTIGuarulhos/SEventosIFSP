<?php
// no direct access
isset($CONFIG) or exit('Acesso Restrito');
$query = "SELECT admin FROM participantes WHERE cpf='{$USER->getCpf()}'";
$result = mysql_fetch_array($DB->Query($query));
?>
<? if (tipoadmin(1, $USER->getCpf(), $SCT_ID, 0)) { ?>
    <ul>
        <? if (tipoadmin(5, $USER->getCpf(), $SCT_ID, 0)) { ?><li><a href="<?php echo $CONFIG->URL_ROOT ?>/?pag=admeventonew<?
                if (isset($_GET['SCT'])) {
                    echo '&SCT=' . $_GET['SCT'];
                }
                ?>">NOVA ATIVIDADE</a></li> <? } ?>
        <? if (tipoadmin(5, $USER->getCpf(), $SCT_ID, 0)) { ?><li><a href="<?php echo $CONFIG->URL_ROOT ?>/?pag=admprogramacaoadmin<?
                if (isset($_GET['SCT'])) {
                    echo '&SCT=' . $_GET['SCT'];
                }
                ?>">EDITAR PROGRAMAÇÃO</a></li> <? } ?>
        <? if (tipoadmin(5, $USER->getCpf(), $SCT_ID, 0)) { ?><li><a href="<?php echo $CONFIG->URL_ROOT ?>/?pag=admalbumnew<?
                if (isset($_GET['SCT'])) {
                    echo '&SCT=' . $_GET['SCT'];
                }
                ?>">NOVO ALBUM</a></li> <? } ?>
        <? if (tipoadmin(5, $USER->getCpf(), $SCT_ID, 0)) { ?><li><a href="<?php echo $CONFIG->URL_ROOT ?>/?pag=admalbumadmin<?
                if (isset($_GET['SCT'])) {
                    echo '&SCT=' . $_GET['SCT'];
                }
                ?>">EDITAR ALBUNS</a></li> <? } ?>
        <? if (tipoadmin(1, $USER->getCpf(), $SCT_ID, 0)) { ?><li><a href="<?php echo $CONFIG->URL_ROOT ?>/?pag=admrelatorios<?
                if (isset($_GET['SCT'])) {
                    echo '&SCT=' . $_GET['SCT'];
                }
                ?>">RELATÓRIOS</a></li> <? } ?>
        <? if (tipoadmin(5, $USER->getCpf(), $SCT_ID, 0)) { ?><li><a href="<?php echo $CONFIG->URL_ROOT ?>/?pag=admrelatorios_eventos<?
                if (isset($_GET['SCT'])) {
                    echo '&SCT=' . $_GET['SCT'];
                }
                ?>">RELATÓRIO DO EVENTO</a></li> <? } ?>
        <? if (tipoadmin(3, $USER->getCpf(), $SCT_ID, 0)) { ?><li><a href="<?php echo $CONFIG->URL_ROOT ?>/?pag=admpresenca<?
                if (isset($_GET['SCT'])) {
                    echo '&SCT=' . $_GET['SCT'];
                }
                ?>">LISTA DE PRESENÇA</a></li> <? } ?>
        <? if (tipoadmin(2, $USER->getCpf(), $SCT_ID, 0)) { ?><li><a href="<?php echo $CONFIG->URL_ROOT ?>/?pag=adminscreverpart<?
                if (isset($_GET['SCT'])) {
                    echo '&SCT=' . $_GET['SCT'];
                }
                ?>">INSCREVER PARTICIPANTE</a></li> <? } ?>
        <? if (tipoadmin(2, $USER->getCpf(), $SCT_ID, 0)) { ?><li><a href="<?php echo $CONFIG->URL_ROOT ?>/?pag=admpresencacod<?
                if (isset($_GET['SCT'])) {
                    echo '&SCT=' . $_GET['SCT'];
                }
                ?>">PRESENÇA BARCODE</a></li> <? } ?>
        <? if (tipoadmin(7, $USER->getCpf(), $SCT_ID, 0)) { ?><li><a href="<?php echo $CONFIG->URL_ROOT ?>/?pag=admusuarios<?
                if (isset($_GET['SCT'])) {
                    echo '&SCT=' . $_GET['SCT'];
                }
                ?>">GERENCIAR USUÁRIOS</a></li> <? } ?>
        <? if (tipoadmin(7, $USER->getCpf(), $SCT_ID, 0)) { ?><li><a href="<?php echo $CONFIG->URL_ROOT ?>/?pag=admconfigedit<?
                if (isset($_GET['SCT'])) {
                    echo '&SCT=' . $_GET['SCT'];
                }
                ?>">CONFIGURAR SISTEMA</a></li> <? } ?>

    </ul>
<? } ?>
