<?
$query = "SELECT SEMTEC, NOME FROM edicao ORDER BY NOME DESC";
$result = $DB->Query($query);
?>

<h1>Anais dos eventos<span class="imgH1 geral"></span></h1>
<br/>
<p>
    Aqui você encontra todos os anais e trabalhos publicados.
</p>

<?
while ($x = mysql_fetch_array($result)):
    $SEMTEC = $x['SEMTEC'];
    $NOME = $x['NOME'];
    $bg = $bg == "f0f0f0" ? "ffffff" : "f0f0f0";
    ?>
    <? if ((file_exists($CONFIG->DIR_ROOT . "/arquivos/anais" . $x['SEMTEC'] . ".zip")) || (file_exists($CONFIG->DIR_ROOT . "/arquivos/artigos" . $x['SEMTEC'] . ".zip"))): ?>
        <div class="box-data">
            <h1 class="evento-data"><?= $NOME ?></h1>
            <div class="evento">
                <? if (file_exists($CONFIG->DIR_ROOT . "/arquivos/anais" . $x['SEMTEC'] . ".zip")): ?>
                    <a href="<?php echo $CONFIG->URL_ROOT . "/arquivos/anais" . $x['SEMTEC'] . ".zip" ?>">Anais</a><br>
                <? endif ?>
                <? if (file_exists($CONFIG->DIR_ROOT . "/arquivos/artigos" . $x['SEMTEC'] . ".zip")): ?>
                    <a href="<?php echo $CONFIG->URL_ROOT . "/arquivos/artigos" . $x['SEMTEC'] . ".zip" ?>">Artigos Aprovados</a><br>
                <? endif ?>
            </div>
        </div>
    <? endif ?>
<? endwhile ?>

