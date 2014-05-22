<?php
// no direct access
isset($CONFIG) or exit('Acesso Restrito');
?>
<li><a href="<?php echo $CONFIG->URL_ROOT ?>/?pag=home<?
    if (isset($_GET['SCT'])) {
        echo '&SCT=' . $_GET['SCT'];
    }
    ?>"><!--<img src="<?php echo $CONFIG->URL_ROOT ?>/includes/imgs/home_icon.png">-->INÍCIO</a></li>
<li><a href="<?php echo $CONFIG->URL_ROOT ?>/?pag=programacao<?
    if (isset($_GET['SCT'])) {
        echo '&SCT=' . $_GET['SCT'];
    }
    ?>">PROGRAMAÇÃO</a></li>
<li><a href="<?php echo $CONFIG->URL_ROOT ?>/?pag=como-chegar<?
    if (isset($_GET['SCT'])) {
        echo '&SCT=' . $_GET['SCT'];
    }
    ?>">COMO CHEGAR</a></li>
<li><a href="<?php echo $CONFIG->URL_ROOT ?>/?pag=contato<?
    if (isset($_GET['SCT'])) {
        echo '&SCT=' . $_GET['SCT'];
    }
    ?>">CONTATO</a></li>
<li><a href="<?php echo $CONFIG->URL_ROOT ?>/?pag=fotos<?
    if (isset($_GET['SCT'])) {
        echo "&SCT=" . $_GET['SCT'];
    }
    ?>">FOTOS</a></li>
<li><a href="<?php echo $CONFIG->URL_ROOT ?>/?pag=verificarcert<?
    if (isset($_GET['SCT'])) {
        echo "&SCT=" . $_GET['SCT'];
    }
    ?>">VALIDAÇÃO</a></li>    