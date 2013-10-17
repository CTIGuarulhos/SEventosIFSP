<li><a href="<?php echo $CONFIG->URL_ROOT ?>/?pag=anais<?
    if (isset($_GET['SCT'])) {
        echo "&SCT=" . $_GET['SCT'];
    }
    ?>">ANAIS</a></li> 
<li><a href="<?php echo $CONFIG->URL_ROOT ?>/?pag=tmpsubmissao<?
    if (isset($_GET['SCT'])) {
        echo "&SCT=" . $_GET['SCT'];
    }
    ?>">SUBMISSÃO</a></li>
