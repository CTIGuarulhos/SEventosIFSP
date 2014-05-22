<?php
// no direct access
isset($CONFIG) or exit('Acesso Restrito');
?>

<?php if ($SESSION->IsLoggedIn()): ?>
    <ul>
        <li><a href="<?php echo $CONFIG->URL_ROOT ?>/?pag=home<?
            if (isset($_GET['SCT'])) {
                echo '&SCT=' . $_GET['SCT'];
            }
            ?>">HOME</a></li>
        <li><a href="<?php echo $CONFIG->URL_ROOT ?>/?pag=meusdados<?
            if (isset($_GET['SCT'])) {
                echo '&SCT=' . $_GET['SCT'];
            }
            ?>">MEUS DADOS</a></li>
        <li><a href="<?php echo $CONFIG->URL_ROOT ?>/?pag=meuseventos<?
            if (isset($_GET['SCT'])) {
                echo '&SCT=' . $_GET['SCT'];
            }
            ?>">MEUS EVENTOS</a></li>
        <li><a href="<?php echo $CONFIG->URL_ROOT ?>/?pag=meuscertificados<?
            if (isset($_GET['SCT'])) {
                echo '&SCT=' . $_GET['SCT'];
            }
            ?>">MEUS CERTIFICADOS</a></li>
        <li><a href="<?php echo $CONFIG->URL_ROOT ?>/logout.php">SAIR</a></li>
    </ul>
<?php endif; ?>
	
