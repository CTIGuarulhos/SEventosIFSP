<?php
// no direct access
isset($CONFIG) or exit('Acesso Restrito');
$query = "SELECT admin FROM participantes WHERE cpf='{$USER->getCpf()}'";
$result = mysql_fetch_array($DB->Query($query));
?>
<?php if (tipoadmin(1, $USER->getCpf(), $SCT_ID, 0)) { ?>
    <ul>
        <?php if (tipoadmin(5, $USER->getCpf(), $SCT_ID, 0)) { ?><li><a href="<?php echo $CONFIG->URL_ROOT ?>/?pag=admeventonew<?php
                   if (isset($_GET['SCT'])) {
                   echo '&SCT=' . $_GET['SCT'];
                   }
                   ?>">NOVA ATIVIDADE</a></li> <?php } ?>
        <?php if (tipoadmin(5, $USER->getCpf(), $SCT_ID, 0)) { ?><li><a href="<?php echo $CONFIG->URL_ROOT ?>/?pag=admprogramacaoadmin<?php
                   if (isset($_GET['SCT'])) {
                   echo '&SCT=' . $_GET['SCT'];
                   }
                   ?>">EDITAR PROGRAMAÇÃO</a></li> <?php } ?>
        <?php if (tipoadmin(5, $USER->getCpf(), $SCT_ID, 0)) { ?><li><a href="<?php echo $CONFIG->URL_ROOT ?>/?pag=admalbumnew<?php
                   if (isset($_GET['SCT'])) {
                   echo '&SCT=' . $_GET['SCT'];
                   }
                   ?>">NOVO ALBUM</a></li> <?php } ?>
        <?php if (tipoadmin(5, $USER->getCpf(), $SCT_ID, 0)) { ?><li><a href="<?php echo $CONFIG->URL_ROOT ?>/?pag=admalbumadmin<?php
                   if (isset($_GET['SCT'])) {
                   echo '&SCT=' . $_GET['SCT'];
                   }
                   ?>">EDITAR ALBUNS</a></li> <?php } ?>
        <?php if (tipoadmin(1, $USER->getCpf(), $SCT_ID, 0)) { ?><li><a href="<?php echo $CONFIG->URL_ROOT ?>/?pag=admrelatorios<?php
                   if (isset($_GET['SCT'])) {
                   echo '&SCT=' . $_GET['SCT'];
                   }
                   ?>">RELATÓRIOS</a></li> <?php } ?>
        <?php if (tipoadmin(5, $USER->getCpf(), $SCT_ID, 0)) { ?><li><a href="<?php echo $CONFIG->URL_ROOT ?>/?pag=admrelatorios_eventos<?php
                   if (isset($_GET['SCT'])) {
                   echo '&SCT=' . $_GET['SCT'];
                   }
                   ?>">RELATÓRIO DO EVENTO</a></li> <?php } ?>
        <?php if (tipoadmin(3, $USER->getCpf(), $SCT_ID, 0)) { ?><li><a href="<?php echo $CONFIG->URL_ROOT ?>/?pag=admpresenca<?php
                   if (isset($_GET['SCT'])) {
                   echo '&SCT=' . $_GET['SCT'];
                   }
                   ?>">LISTA DE PRESENÇA</a></li> <?php } ?>
        <?php if (tipoadmin(2, $USER->getCpf(), $SCT_ID, 0)) { ?><li><a href="<?php echo $CONFIG->URL_ROOT ?>/?pag=adminscreverpart<?php
                   if (isset($_GET['SCT'])) {
                   echo '&SCT=' . $_GET['SCT'];
                   }
                   ?>">INSCREVER PARTICIPANTE</a></li> <?php } ?>
        <?php if (tipoadmin(2, $USER->getCpf(), $SCT_ID, 0)) { ?><li><a href="<?php echo $CONFIG->URL_ROOT ?>/?pag=admpresencacod<?php
                   if (isset($_GET['SCT'])) {
                   echo '&SCT=' . $_GET['SCT'];
                   }
                   ?>">PRESENÇA BARCODE</a></li> <?php } ?>
        <?php if (tipoadmin(7, $USER->getCpf(), $SCT_ID, 0)) { ?><li><a href="<?php echo $CONFIG->URL_ROOT ?>/?pag=admusuarios<?php
                   if (isset($_GET['SCT'])) {
                   echo '&SCT=' . $_GET['SCT'];
                   }
                   ?>">GERENCIAR USUÁRIOS</a></li> <?php } ?>
        <?php if (tipoadmin(7, $USER->getCpf(), $SCT_ID, 0)) { ?><li><a href="<?php echo $CONFIG->URL_ROOT ?>/?pag=admconfigedit<?php
                   if (isset($_GET['SCT'])) {
                   echo '&SCT=' . $_GET['SCT'];
                   }
                   ?>">CONFIGURAR SISTEMA</a></li> <?php } ?>

    </ul>
<?php } ?>
