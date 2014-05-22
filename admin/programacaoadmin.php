<?php
if (!$SESSION->IsLoggedIn()) {
    $Return_URL = "$CONFIG->URL_ROOT";
    header("Location: $Return_URL");
    unset($Return_URL);
}
if (tipoadmin(5, $USER->getCpf(), $SCT_ID)) {
    $query = "SELECT * FROM eventos WHERE semtec='" . $SCT_ID . "' ORDER BY `data`,hora";
    $eventos = $DB->Query($query);

//Apenas para controle de exibição
    $primeiro = true;

//Dias da semana
    $diaSemana = array('Domingo', 'Segunda-feira', 'Terça-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira', 'Sábado');

//$header['css'][] = array("href"=>CSS_DIR."/programacao.css", "media"=>"all");
    $deletarevento = safe_sql($_REQUEST['deletarevento']);
    $deletarpalestrante = safe_sql($_REQUEST['deletarpalestrante']);


    if (isset($deletarevento)):
        require_once("eventoadmin_functions.php");
        deletar_evento($deletarevento);
        echo "<meta HTTP-EQUIV='refresh' CONTENT='0;URL=$Esta_Pagina'>";
    endif;
    if (isset($deletarpalestrante)):
        require_once("eventoadmin_functions.php");
        deletar_palestrante($deletarpalestrante);
    //echo "<meta HTTP-EQUIV='refresh' CONTENT='0;URL=$Esta_Pagina'>";
    endif;
    ?>

    <h1>EDITAR PROGRAMAÇÃO<span class="imgH1 geral"></span></h1>
    <br/>

    <p>
        Procure o dia e o evento e selecione <img src="<?php echo $CONFIG->URL_ROOT ?>/includes/imgs/view.png" name="EDITAR" ALT="EDITAR" VALUE="EDITAR" title="EDITAR"> para editar e <img src="<?php echo $CONFIG->URL_ROOT ?>/includes/imgs/cancel.png" name="DELETAR" ALT="DELETAR" VALUE="DELETAR" title="DELETAR"> para excluir.
    <hr style="border:1px #a5a5a5 dashed;margin:15px 0px;" /><center>UTILIZE ESSA FERRAMENTA COM MUITO CUIDADO!</center> <br><br>
    </p>

    <p>
        <?php echo substituir_acentos($CONFIG->PROGRAMACAO) ?>
    </p>

    <?php
    if (isset($_SESSION['temp']['inscricaoOK'])) {
        if ($_SESSION['temp']['inscricaoOK'] == true)
            HTML_SuccessMessage($_SESSION['temp']['inscricaoMSG']);
        else
            HTML_ErrorMessage($_SESSION['temp']['inscricaoMSG']);
        //Destroi as variaveis temporárias
        unset($_SESSION['temp']['inscricaoOK']);
        unset($_SESSION['temp']['inscricaoMSG']);
    }
    ?>

    <?
    if (@mysql_num_rows($eventos) > 0):  //if 01

        while ($evento = mysql_fetch_array($eventos)):

            $query = "SELECT * FROM participacoes WHERE id_evento='{$evento['id']}'";

            $inscritos = @mysql_num_rows($DB->Query($query));
            $total_vagas = $evento['vagas'];

            $dt = date_create($evento['data']);         //datetime
            $data_evento = date_format($dt, "d/m/Y");   //string - data do evento
            $hora_evento = substr($evento['hora'], 0, 5); //string - hora do evento
            $ts_evento = mktime(23, 59, 59, date_format($dt, "m"), date_format($dt, "d"), date_format($dt, "Y"));  //timestamp da data do evento
            //$ts_evento = $DATA_MAX; //Prazo máximo para inscrições

            if ($inscritos < $total_vagas) {
                if (time() < $ts_evento)
                    $inscricoes_abertas = true;
                else
                    $inscricoes_abertas = "Inscri&ccedil;&otilde;es encerradas";
            } else {
                $inscricoes_abertas = "Vagas esgotadas";
            }

            $tipo = array('', 'Palestra', 'Mini-curso', 'Mesa redonda', 'Seção Oral', 'Oficina');

            if ($data != $evento['data']) {
                if ($primeiro) {
                    $primeiro = false;
                } else {
                    echo "</div>";
                }
                ?>

                <div class="box-data">
                    <h1 class="evento-data"><?= $data_evento . ' - ' . $diaSemana[date('w', $ts_evento)] ?></h1>
                    <?
                    $data = $evento['data'];
                }
                ?>

                <div class="evento">

                    <h2><?= $evento['id'] ?> - <?= $evento['titulo'] ?><? if ($evento['tipo'] != 0): ?> - <b><?= $tipo[$evento['tipo']] ?></b><? endif ?></h2><div>


                    </div>

                    <? if (strlen($evento['descricao'])): ?>
                        <br/>
                        <p><?= nl2br($evento['descricao']) ?></p>
                    <? endif ?>

                    <? if ($evento['tipo']): ?>
                        <small style="float:right">Vagas: <?= $total_vagas - $inscritos ?> de <?= $total_vagas ?></small>
                    <? endif ?>
                    <small>Local: <?= $evento['local'] ?></small>
                    <?
                    $query = "SELECT cod_palestrante FROM part_palestrante WHERE cod_palestra='{$evento['id']}'";
                    $palestrantes = $DB->Query($query);
                    if (@mysql_num_rows($palestrantes) > 0):  //if 01
                        if (@mysql_num_rows($palestrantes) == 1):  //if 01 
                            ?>
                            <br><small>Palestrante:</small>
                        <? else : ?>
                            <br><small>Palestrantes:</small>
                        <? endif; ?>
                        <? while ($palestrante = mysql_fetch_array($palestrantes)): ?>
                            <?
                            $query = "SELECT palestrante FROM palestrante WHERE codigo='{$palestrante['cod_palestrante']}'";
                            $nomepalestrante = mysql_fetch_array($DB->Query($query));
                            ?>
                            <form method="post" action="<?= $Esta_Pagina ?>">
                                <input type="hidden" name="deletarpalestrante" value="<?= $palestranteid['codigo'] ?>" />

                                <?
                                $query = "SELECT codigo FROM part_palestrante WHERE cod_palestrante='{$palestrante['cod_palestrante']}' AND cod_palestra ='{$evento['id']}'";
                                $palestranteid = mysql_fetch_array($DB->Query($query));
                                ?>
                                <a href="<?php echo $CONFIG->URL_ROOT ?>/?pag=admcertificadopalestrante&id=<?= $evento['id'] ?>"><img src="<?php echo $CONFIG->URL_ROOT ?>/includes/imgs/print.png" name="Imprimir Certificado" ALT="Imprimir Certificado" VALUE="Imprimir Certificado" title="Imprimir Certificado"></a>
                                <input type="image" src="<?php echo $CONFIG->URL_ROOT ?>/includes/imgs/cancel.png" name="DELETAR" ALT="DELETAR" VALUE="DELETAR" title="DELETAR" onclick="alert('Você está excluindo o palestrante <?= $nomepalestrante['palestrante'] ?> do evento <?= $evento['id'] ?> - <?= $evento['titulo'] ?>')"><small><?= $nomepalestrante['palestrante'] ?></small><br>
                            </form>
                        <? endwhile; ?>
                    <? endif; ?>
                    <form method ="post" action="<?= $Esta_Pagina ?>">
                        <input type="hidden" name="deletarevento" value="<?= $evento['id'] ?>" />
                        <!--<a href="<?php echo $CONFIG->URL_ROOT ?>/?pag=adminscreverpale&evento=<?= $evento['id'] ?>">Adicionar Palestrante</a>-->

                        <br/>	
                        <div class="right"><a href="<?php echo $CONFIG->URL_ROOT ?>/?pag=admeventoedit&id=<?= $evento['id'] ?>"><img src="<?php echo $CONFIG->URL_ROOT ?>/includes/imgs/view.png" name="EDITAR" ALT="EDITAR" VALUE="EDITAR" title="EDITAR"></a>&nbsp;&nbsp;<input type="image" src="<?php echo $CONFIG->URL_ROOT ?>/includes/imgs/cancel.png" name="DELETAR" ALT="DELETAR" VALUE="DELETAR" title="DELETAR" onclick="alert('Você está excluindo o evento <?= $evento['id'] ?> - <?= $evento['titulo'] ?><? if ($evento['tipo'] != 0): ?> - <?= $tipo[$evento['tipo']] ?><? endif ?>')">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div><br>

                        <small>Data: <?= $data_evento ?>&nbsp;&nbsp;<b>|</b>&nbsp;&nbsp;Horário: <?= $hora_evento ?>&nbsp;&nbsp;<b>|</b>&nbsp;&nbsp;Duração aprox.: <?= $evento['duracao'] ?> min.</small>
                    </form></div>

                <?
            endwhile;
            echo "</div>";
        else:  //if 01
            ?>

            <h3>Nenhum evento disponível</h3>
        <? endif  //if 01  ?>
    <? } ?>
    