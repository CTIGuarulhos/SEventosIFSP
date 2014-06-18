<?php
$query = "SELECT * FROM album WHERE semtec='" . $SCT_ID . "' ORDER BY `data`,id";
$albuns = $DB->Query($query);

//Apenas para controle de exibição
$primeiro = true;

//Dias da semana
$diaSemana = array('Domingo', 'Segunda-feira', 'Terça-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira', 'Sábado');
?>

<h1>Galeria de Fotos<span class="imgH1 geral"></span></h1>
<br/>

<p>
    Veja aqui as fotos d<?php echo $EVENTO['GENERO'] ?> <?php echo $EVENTO['NOME'] ?>.
</p>

<p>
    <?php echo substituir_acentos($CONFIG->PROGRAMACAO) ?>
</p>


<?
if (@mysql_num_rows($albuns) > 0):  //if 01

    while ($album = mysql_fetch_array($albuns)):

        $query = "SELECT * FROM album WHERE id_evento='{$album['id']}'";
        $dt = date_create($album['data']);         //datetime
        $data_album = date_format($dt, "d/m/Y");   //string - data do evento
        $ts_album = mktime(23, 59, 59, date_format($dt, "m"), date_format($dt, "d"), date_format($dt, "Y"));  //timestamp da data do evento
        //$ts_evento = $DATA_MAX; //Prazo máximo para inscrições


        if ($data != $album['data']) {
            if ($primeiro) {
                $primeiro = false;
            } else {
                echo "</div>";
            }
            ?>

            <div class="box-data">
                <h1 class="evento-data"><?= $data_album . ' - ' . $diaSemana[date('w', $ts_album)] ?></h1>
                <?
                $data = $album['data'];
            }
            ?>

            <div class="evento">
                <? exibir_fotos_picasa($album['usuario'], $album['album']); ?>
            </div>

            <?
        endwhile;
        echo "</div>";
    else:  //if 01
        ?>

        <h3>Nenhum Album disponível</h3>
                                                                                                    <? endif  //if 01 ?>
