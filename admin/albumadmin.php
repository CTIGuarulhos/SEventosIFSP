<?php
if (!$SESSION->IsLoggedIn()) {
    $Return_URL = "$CONFIG->URL_ROOT";
    header("Location: $Return_URL");
    unset($Return_URL);
}
if (tipoadmin(5, $USER->getCpf(), $SCT_ID)) {
    $query = "SELECT * FROM album WHERE semtec='" . $SCT_ID . "' ORDER BY `data`,id";
    $albuns = $DB->Query($query);

//Apenas para controle de exibição
    $primeiro = true;

//Dias da semana
    $diaSemana = array('Domingo', 'Segunda-feira', 'Terça-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira', 'Sábado');

//$header['css'][] = array("href"=>CSS_DIR."/programacao.css", "media"=>"all");
    $deletaralbum = safe_sql($_REQUEST['deletaralbum']);



    require_once("albumadmin_functions.php");
    if (isset($deletaralbum) AND strlen($deletaralbum) > 0):
        deletar_album($deletaralbum);
        echo "<meta HTTP-EQUIV='refresh' CONTENT='0;URL=$Esta_Pagina'>";
    endif;
    ?>

    <h1>EDITAR ALBUM<span class="imgH1 geral"></span></h1>
    <br/>

    <p>
        Procure o dia e o album e selecione <img src="<?php echo $CONFIG->URL_ROOT ?>/includes/imgs/view.png" name="EDITAR" ALT="EDITAR" VALUE="EDITAR" title="EDITAR"> para editar e <img src="<?php echo $CONFIG->URL_ROOT ?>/includes/imgs/cancel.png" name="DELETAR" ALT="DELETAR" VALUE="DELETAR" title="DELETAR"> para excluir.
    <hr style="border:1px #a5a5a5 dashed;margin:15px 0px;" /><center>UTILIZE ESSA FERRAMENTA COM MUITO CUIDADO!</center> <br><br>
    </p>


    <?php
    if (@mysql_num_rows($albuns) > 0):  //if 01
        while ($album = mysql_fetch_array($albuns)):

            $dt = date_create($album['data']);         //datetime
            $data_album = date_format($dt, "d/m/Y");   //string - data do album
            $hora_album = substr($album['hora'], 0, 5); //string - hora do album
            $ts_album = mktime(23, 59, 59, date_format($dt, "m"), date_format($dt, "d"), date_format($dt, "Y"));  //timestamp da data do album
//$ts_album = $DATA_MAX; //Prazo máximo para inscrições


            if ($data != $album['data']) {
                if ($primeiro) {
                    $primeiro = false;
                } else {
                    echo "</div>";
                }
                ?>

                <div class="box-data">
                    <h1 class="evento-data"><?php echo $data_album . ' - ' . $diaSemana[date('w', $ts_album)] ?></h1>
                    <?php
                    $data = $album['data'];
                }
                ?> 

                <div class="evento"><form method="post" action="<?php echo $Esta_Pagina ?>">
                        <input type="hidden" name="deletaralbum" value="<?php echo $album['id'] ?>" />
                        <?php exibir_fotos_picasa($album['usuario'], $album['album']); ?>
                        <div class="right"><a href="<?php echo $CONFIG->URL_ROOT ?>?pag=admalbumedit&id=<?php echo $album['id'] ?>"><img src="<?php echo $CONFIG->URL_ROOT ?>/includes/imgs/view.png" name="EDITAR" ALT="EDITAR" VALUE="EDITAR" title="EDITAR"></a>&nbsp;&nbsp;<input type="image" src="<?php echo $CONFIG->URL_ROOT ?>/includes/imgs/cancel.png" name="DELETAR" ALT="DELETAR" VALUE="DELETAR" title="DELETAR" onclick="alert('Você está excluindo o album <?php echo $album['id'] ?> - <?php echo $album['album'] ?>')">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div><br>


                        </div>
                        <?php
                    endwhile;
                    echo "</div>";
                else:  //if 01
                    ?>

                    <h3>Nenhum album disponível</h3>
                <?php endif;  //if 01  ?>
            <?php } ?>

