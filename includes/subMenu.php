<?php
// no direct access
isset($CONFIG) or exit('Acesso Restrito');
?>

<?php if ($SESSION->IsLoggedIn()): ?>
    <ul>
        <li><a href="<?php echo $CONFIG->URL_ROOT ?>/?pag=home<?php
               if (isset($_GET['SCT'])) {
               echo '&SCT=' . $_GET['SCT'];
               }
               ?>">HOME</a></li>
        <li><a href="<?php echo $CONFIG->URL_ROOT ?>/?pag=meusdados<?php
               if (isset($_GET['SCT'])) {
               echo '&SCT=' . $_GET['SCT'];
               }
               ?>">MEUS DADOS</a></li>
        <li><a href="<?php echo $CONFIG->URL_ROOT ?>/?pag=meuseventos<?php
               if (isset($_GET['SCT'])) {
               echo '&SCT=' . $_GET['SCT'];
               }
               ?>">MEUS EVENTOS</a></li>
        <li><a href="<?php echo $CONFIG->URL_ROOT ?>/?pag=meuscertificados<?php
               if (isset($_GET['SCT'])) {
               echo '&SCT=' . $_GET['SCT'];
               }
               ?>">MEUS CERTIFICADOS</a></li>
        <li><a href="<?php echo $CONFIG->URL_ROOT ?>/logout.php">SAIR</a></li>
    </ul>
<?php endif; ?>
	
